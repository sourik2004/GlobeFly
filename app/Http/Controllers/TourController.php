<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;
use App\Models\Destination;

class TourController extends Controller
{
    // Public: List packages
    public function index(Request $request)
    {
        $query = TourPackage::where('status', 'active')->with('destination');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('destination', function($d) use ($search) {
                      $d->where('name', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        if ($request->filled('duration')) {
            $query->where('duration_days', '<=', $request->input('duration'));
        }

        $packages = $query->latest()->get();
        $destinations = Destination::all();

        return view('tours.index', compact('packages', 'destinations'));
    }

    // Public: Show single package
    public function show($id)
    {
        $package = TourPackage::with(['destination', 'manager'])->findOrFail($id);
        return view('tours.show', compact('package'));
    }

    // Manager: Create package
    public function create()
    {
        $destinations = Destination::all();
        return view('tours.create', compact('destinations'));
    }

    // Manager: Store package
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'destination_id' => 'required|exists:destinations,id',
            'image_url' => 'nullable|url',
            'max_slots' => 'required|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        TourPackage::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'destination_id' => $request->destination_id,
            'tour_manager_id' => auth()->id(),
            'image_url' => $request->image_url ?? 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=600&q=80',
            'max_slots' => $request->max_slots,
            'available_slots' => $request->max_slots,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active'
        ]);

        return redirect()->route('dashboard')->with('success', 'Tour package created successfully!');
    }

    // Manager: Edit package
    public function edit($id)
    {
        $package = TourPackage::findOrFail($id);
        
        if ($package->tour_manager_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $destinations = Destination::all();
        return view('tours.edit', compact('package', 'destinations'));
    }

    // Manager: Update package
    public function update(Request $request, $id)
    {
        $package = TourPackage::findOrFail($id);

        if ($package->tour_manager_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'destination_id' => 'required|exists:destinations,id',
            'image_url' => 'nullable|url',
            'max_slots' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive'
        ]);

        $slotDiff = $request->max_slots - $package->max_slots;
        $newAvailable = max(0, $package->available_slots + $slotDiff);

        $package->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'destination_id' => $request->destination_id,
            'image_url' => $request->image_url,
            'max_slots' => $request->max_slots,
            'available_slots' => $newAvailable,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status
        ]);

        return redirect()->route('dashboard')->with('success', 'Tour package updated successfully!');
    }

    // Manager: Destroy package
    public function destroy($id)
    {
        $package = TourPackage::findOrFail($id);

        if ($package->tour_manager_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $package->delete();
        return redirect()->route('dashboard')->with('success', 'Tour package deleted successfully!');
    }
}
