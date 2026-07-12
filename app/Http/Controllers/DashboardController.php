<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\TourPackage;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\User;
use App\Models\Destination;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $destinations = Destination::all();
            $usersCount = User::count();
            $bookingsCount = Booking::count();
            $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_price');
            $recentBookings = Booking::with(['user', 'bookable'])->latest()->take(10)->get();

            return view('dashboards.admin', compact('destinations', 'usersCount', 'bookingsCount', 'totalRevenue', 'recentBookings'));
        }

        if ($user->role === 'tour_manager') {
            $packages = TourPackage::where('tour_manager_id', $user->id)->get();
            $packageIds = $packages->pluck('id')->toArray();
            
            $bookings = Booking::where('bookable_type', TourPackage::class)
                ->whereIn('bookable_id', $packageIds)
                ->with(['user', 'bookable'])
                ->latest()
                ->get();
                
            $revenue = Booking::where('bookable_type', TourPackage::class)
                ->whereIn('bookable_id', $packageIds)
                ->where('payment_status', 'paid')
                ->sum('total_price');

            return view('dashboards.manager', compact('packages', 'bookings', 'revenue'));
        }

        if ($user->role === 'hotel_partner') {
            $hotels = Hotel::where('hotel_partner_id', $user->id)->with('rooms')->get();
            $hotelIds = $hotels->pluck('id')->toArray();
            
            $roomIds = HotelRoom::whereIn('hotel_id', $hotelIds)->pluck('id')->toArray();
            
            $bookings = Booking::where('bookable_type', HotelRoom::class)
                ->whereIn('bookable_id', $roomIds)
                ->with(['user', 'bookable.hotel'])
                ->latest()
                ->get();
                
            $revenue = Booking::where('bookable_type', HotelRoom::class)
                ->whereIn('bookable_id', $roomIds)
                ->where('payment_status', 'paid')
                ->sum('total_price');

            return view('dashboards.partner', compact('hotels', 'bookings', 'revenue'));
        }

        // Default: traveler role
        $trips = Trip::where('user_id', $user->id)->latest()->get();
        $bookings = Booking::where('user_id', $user->id)->with('bookable')->latest()->get();
        
        $totalSpent = Booking::where('user_id', $user->id)->where('payment_status', 'paid')->sum('total_price');
        $activeTripsCount = $trips->count();

        return view('dashboards.traveler', compact('trips', 'bookings', 'totalSpent', 'activeTripsCount'));
    }
}
