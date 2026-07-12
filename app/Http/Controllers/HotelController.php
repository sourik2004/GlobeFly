<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelRoom;

class HotelController extends Controller
{
    // Public: List all hotels
    public function index(Request $request)
    {
        $query = Hotel::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('stars')) {
            $query->where('star_rating', '>=', $request->input('stars'));
        }

        $hotels = $query->latest()->get();
        return view('hotels.index', compact('hotels'));
    }

    // Public: Show hotel and rooms
    public function show($id)
    {
        $hotel = Hotel::with('rooms')->findOrFail($id);
        return view('hotels.show', compact('hotel'));
    }

    // Partner: Create Hotel
    public function create()
    {
        return view('hotels.create');
    }

    // Partner: Store Hotel
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'address' => 'nullable|string',
            'star_rating' => 'required|integer|min:1|max:5',
            'image_url' => 'nullable|url',
        ]);

        Hotel::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'address' => $request->address,
            'star_rating' => $request->star_rating,
            'hotel_partner_id' => auth()->id(),
            'image_url' => $request->image_url ?? 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=600&q=80',
        ]);

        return redirect()->route('dashboard')->with('success', 'Hotel profile created successfully!');
    }

    // Partner: Edit Hotel
    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);

        if ($hotel->hotel_partner_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('hotels.edit', compact('hotel'));
    }

    // Partner: Update Hotel
    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        if ($hotel->hotel_partner_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'address' => 'nullable|string',
            'star_rating' => 'required|integer|min:1|max:5',
            'image_url' => 'nullable|url',
        ]);

        $hotel->update([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'address' => $request->address,
            'star_rating' => $request->star_rating,
            'image_url' => $request->image_url,
        ]);

        return redirect()->route('dashboard')->with('success', 'Hotel details updated successfully!');
    }

    // Partner: Delete Hotel
    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);

        if ($hotel->hotel_partner_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $hotel->delete();
        return redirect()->route('dashboard')->with('success', 'Hotel profile removed successfully.');
    }

    // Partner: Create Hotel Room
    public function createRoom($hotelId)
    {
        $hotel = Hotel::findOrFail($hotelId);

        if ($hotel->hotel_partner_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('hotels.rooms.create', compact('hotel'));
    }

    // Partner: Store Hotel Room
    public function storeRoom(Request $request, $hotelId)
    {
        $hotel = Hotel::findOrFail($hotelId);

        if ($hotel->hotel_partner_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'room_type' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'amenities' => 'required|string', // comma separated WiFi, AC, TV
            'image_url' => 'nullable|url',
        ]);

        // Convert amenities string to array
        $amenitiesArr = array_map('trim', explode(',', $request->amenities));

        HotelRoom::create([
            'hotel_id' => $hotel->id,
            'room_type' => $request->room_type,
            'price_per_night' => $request->price_per_night,
            'capacity' => $request->capacity,
            'amenities' => $amenitiesArr,
            'is_available' => true,
            'image_url' => $request->image_url ?? 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80',
        ]);

        return redirect()->route('dashboard')->with('success', 'Room added successfully to ' . $hotel->name);
    }

    // Partner: Edit Room
    public function editRoom($roomId)
    {
        $room = HotelRoom::with('hotel')->findOrFail($roomId);

        if ($room->hotel->hotel_partner_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('hotels.rooms.edit', compact('room'));
    }

    // Partner: Update Room
    public function updateRoom(Request $request, $roomId)
    {
        $room = HotelRoom::with('hotel')->findOrFail($roomId);

        if ($room->hotel->hotel_partner_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'room_type' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'amenities' => 'required|string', // comma separated
            'image_url' => 'nullable|url',
            'is_available' => 'required|boolean',
        ]);

        $amenitiesArr = array_map('trim', explode(',', $request->amenities));

        $room->update([
            'room_type' => $request->room_type,
            'price_per_night' => $request->price_per_night,
            'capacity' => $request->capacity,
            'amenities' => $amenitiesArr,
            'is_available' => $request->is_available,
            'image_url' => $request->image_url,
        ]);

        return redirect()->route('dashboard')->with('success', 'Room updated successfully.');
    }

    // Partner: Delete Room
    public function destroyRoom($roomId)
    {
        $room = HotelRoom::with('hotel')->findOrFail($roomId);

        if ($room->hotel->hotel_partner_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $room->delete();
        return redirect()->route('dashboard')->with('success', 'Room removed successfully.');
    }
}
