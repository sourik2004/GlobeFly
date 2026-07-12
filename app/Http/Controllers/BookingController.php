<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\TourPackage;
use App\Models\HotelRoom;
use App\Models\Vehicle;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Checkout screen
    public function checkout(Request $request)
    {
        $bookableType = $request->input('bookable_type');
        $bookableId = $request->input('bookable_id');
        $startDate = $request->input('start_date', Carbon::today()->toDateString());
        $endDate = $request->input('end_date');
        $days = 1;

        if ($bookableType === TourPackage::class) {
            $bookable = TourPackage::findOrFail($bookableId);
            $totalPrice = $bookable->price;
            $endDate = Carbon::parse($startDate)->addDays($bookable->duration_days - 1)->toDateString();
        } elseif ($bookableType === HotelRoom::class) {
            $bookable = HotelRoom::with('hotel')->findOrFail($bookableId);
            if ($endDate) {
                $days = max(1, Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)));
            } else {
                $endDate = Carbon::parse($startDate)->addDay()->toDateString();
            }
            $totalPrice = $bookable->price_per_night * $days;
        } elseif ($bookableType === Vehicle::class) {
            $bookable = Vehicle::findOrFail($bookableId);
            if ($endDate) {
                $days = max(1, Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)));
            } else {
                $endDate = Carbon::parse($startDate)->addDay()->toDateString();
            }
            $totalPrice = $bookable->price_per_day * $days;
        } else {
            abort(400, 'Invalid bookable type.');
        }

        // Razorpay API Credentials and Order Creation Setup
        $razorpayKeyId = config('services.razorpay.key_id');
        $razorpayKeySecret = config('services.razorpay.key_secret');
        $isLiveRazorpay = !empty($razorpayKeyId) && str_starts_with($razorpayKeyId, 'rzp_') && !empty($razorpayKeySecret);
        $razorpayOrderId = null;

        if ($isLiveRazorpay) {
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                    'amount' => round($totalPrice * 100), // amount in paise
                    'currency' => 'INR',
                    'receipt' => 'rcpt_' . substr(uniqid(), 0, 15),
                ]));
                curl_setopt($ch, CURLOPT_USERPWD, $razorpayKeyId . ':' . $razorpayKeySecret);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                
                $result = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($httpCode === 200 || $httpCode === 201) {
                    $orderData = json_decode($result, true);
                    $razorpayOrderId = $orderData['id'] ?? null;
                } else {
                    \Illuminate\Support\Facades\Log::warning('Razorpay Order Creation Failed (falling back to simulation): ' . $result);
                    $isLiveRazorpay = false;
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Razorpay Order Exception: ' . $e->getMessage());
                $isLiveRazorpay = false;
            }
        }

        return view('bookings.checkout', compact(
            'bookable', 
            'bookableType', 
            'bookableId', 
            'startDate', 
            'endDate', 
            'totalPrice', 
            'days',
            'isLiveRazorpay',
            'razorpayKeyId',
            'razorpayOrderId'
        ));
    }

    // Process checkout
    public function store(Request $request)
    {
        $request->validate([
            'bookable_type' => 'required|string',
            'bookable_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|string',
            'special_requests' => 'nullable|string',
            'razorpay_payment_id' => 'required_if:payment_method,Razorpay|nullable|string',
            'razorpay_order_id' => 'nullable|string',
            'razorpay_signature' => 'nullable|string',
        ]);

        $bookableType = $request->bookable_type;
        $bookableId = $request->bookable_id;
        $paymentMethod = $request->payment_method;

        // Perform Razorpay signature verification if running in live credentials mode
        if ($paymentMethod === 'Razorpay') {
            $razorpayKeyId = config('services.razorpay.key_id');
            $razorpayKeySecret = config('services.razorpay.key_secret');
            $isLiveRazorpay = !empty($razorpayKeyId) && str_starts_with($razorpayKeyId, 'rzp_') && !empty($razorpayKeySecret);

            if ($isLiveRazorpay && $request->filled('razorpay_signature')) {
                $orderId = $request->razorpay_order_id;
                $paymentId = $request->razorpay_payment_id;
                $signature = $request->razorpay_signature;

                $expectedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $razorpayKeySecret);

                if (!hash_equals($expectedSignature, $signature)) {
                    return back()->with('error', 'Razorpay signature verification failed. Please try again.');
                }
            }

            $paymentMethod = 'Razorpay (' . ($request->razorpay_payment_id ?? 'Simulated') . ')';
        }

        // Verify resource availability
        if ($bookableType === TourPackage::class) {
            $package = TourPackage::findOrFail($bookableId);
            if ($package->available_slots <= 0) {
                return back()->with('error', 'Sorry, this tour package is fully booked!');
            }
            $package->decrement('available_slots');
        } elseif ($bookableType === HotelRoom::class) {
            $room = HotelRoom::findOrFail($bookableId);
            if (!$room->is_available) {
                return back()->with('error', 'Sorry, this room is no longer available!');
            }
        } elseif ($bookableType === Vehicle::class) {
            $vehicle = Vehicle::findOrFail($bookableId);
            if (!$vehicle->is_available) {
                return back()->with('error', 'Sorry, this vehicle is no longer available!');
            }
        }

        // Create booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'bookable_type' => $bookableType,
            'bookable_id' => $bookableId,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $request->total_price,
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'payment_method' => $paymentMethod,
            'special_requests' => $request->special_requests,
        ]);

        return redirect()->route('booking.show', $booking->id)->with('success', 'Booking confirmed successfully!');
    }

    // Show single booking receipt
    public function show($id)
    {
        $booking = Booking::with('user')->findOrFail($id);
        
        // Ensure user can only view their own bookings, or manager/admin
        if ($booking->user_id !== auth()->id() && auth()->user()->role === 'traveler') {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    // Cancel booking
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== auth()->id() && auth()->user()->role === 'traveler') {
            abort(403);
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'This booking has already been cancelled.');
        }

        // Revert slots if it's a tour package
        if ($booking->bookable_type === TourPackage::class) {
            $package = TourPackage::find($booking->bookable_id);
            if ($package) {
                $package->increment('available_slots');
            }
        }

        $booking->update([
            'status' => 'cancelled',
            'payment_status' => 'refunded'
        ]);

        return back()->with('success', 'Booking cancelled and payment refunded successfully!');
    }

    // Admin/Manager/Partner update status
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'payment_status' => 'required|in:pending,paid,refunded'
        ]);

        // If status changing to cancelled, and was confirmed, restore slots
        if ($request->status === 'cancelled' && $booking->status !== 'cancelled') {
            if ($booking->bookable_type === TourPackage::class) {
                $package = TourPackage::find($booking->bookable_id);
                if ($package) {
                    $package->increment('available_slots');
                }
            }
        }

        $booking->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status
        ]);

        return back()->with('success', 'Booking status updated successfully!');
    }
}
