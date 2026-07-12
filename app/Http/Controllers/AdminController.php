<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // Save new destination
    public function storeDestination(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:destinations,name',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coordinates' => 'nullable|string',
            'weather_info' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        Destination::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'location' => $request->location,
            'description' => $request->description,
            'coordinates' => $request->coordinates,
            'weather_info' => $request->weather_info,
            'image_url' => $request->image_url ?? 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=600&q=80',
        ]);

        return back()->with('success', 'Destination created successfully!');
    }

    // Update destination
    public function updateDestination(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:destinations,name,' . $destination->id,
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coordinates' => 'nullable|string',
            'weather_info' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $destination->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'location' => $request->location,
            'description' => $request->description,
            'coordinates' => $request->coordinates,
            'weather_info' => $request->weather_info,
            'image_url' => $request->image_url,
        ]);

        return back()->with('success', 'Destination updated successfully!');
    }

    // Delete destination
    public function destroyDestination($id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();

        return back()->with('success', 'Destination deleted successfully.');
    }

    // Update user role
    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'role' => 'required|in:traveler,tour_manager,hotel_partner,admin',
        ]);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', "Role for {$user->name} updated to {$request->role}!");
    }
}
