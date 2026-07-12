<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;
use App\Models\Trip;
use Carbon\Carbon;

class TripController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    // Show AI Planner Form
    public function planner()
    {
        return view('ai.planner');
    }

    // Generate Itinerary
    public function generate(Request $request)
    {
        $request->validate([
            'destination' => 'required|string|max:255',
            'days' => 'required|integer|min:1|max:14',
            'budget' => 'required|numeric|min:50',
            'interests' => 'required|array|min:1',
            'start_date' => 'required|date|after_or_equal:today',
        ]);

        $destination = $request->destination;
        $days = $request->days;
        $budget = $request->budget;
        $interests = $request->interests;
        $startDate = $request->start_date;

        // Generate itinerary data
        $itineraryData = $this->gemini->generateItinerary($destination, $days, $budget, $interests);

        // Add additional variables for display & saving
        $endDate = Carbon::parse($startDate)->addDays($days - 1)->toDateString();

        return view('ai.itinerary', compact('itineraryData', 'destination', 'days', 'budget', 'interests', 'startDate', 'endDate'));
    }

    // Save generated trip
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'budget' => 'required|numeric',
            'preferences' => 'required|json',
            'itinerary_data' => 'required|json',
        ]);

        $trip = Trip::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'budget' => $request->budget,
            'preferences' => json_decode($request->preferences, true),
            'itinerary_data' => json_decode($request->itinerary_data, true),
        ]);

        return redirect()->route('trip.show', $trip->id)->with('success', 'Trip itinerary saved to your dashboard!');
    }

    // View saved trip
    public function show($id)
    {
        $trip = Trip::with('expenses')->findOrFail($id);

        if ($trip->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Calculate expense metrics
        $expensesByCategory = $trip->expenses->groupBy('category')->map(fn($item) => $item->sum('amount'));
        $totalSpent = $trip->expenses->sum('amount');
        $remainingBudget = $trip->budget - $totalSpent;

        return view('ai.show_trip', compact('trip', 'expensesByCategory', 'totalSpent', 'remainingBudget'));
    }

    // Delete saved trip
    public function destroy($id)
    {
        $trip = Trip::findOrFail($id);

        if ($trip->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $trip->delete();
        return redirect()->route('dashboard')->with('success', 'Trip deleted successfully.');
    }
}
