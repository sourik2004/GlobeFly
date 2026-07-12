<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Trip;

class ExpenseController extends Controller
{
    // Log a new expense
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|in:food,transport,accommodation,activities,shopping,other',
            'expense_date' => 'required|date',
        ]);

        $trip = Trip::findOrFail($request->trip_id);

        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }

        Expense::create([
            'trip_id' => $request->trip_id,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'category' => $request->category,
            'expense_date' => $request->expense_date,
        ]);

        return back()->with('success', 'Expense logged successfully!');
    }

    // Delete an expense
    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);

        if ($expense->user_id !== auth()->id()) {
            abort(403);
        }

        $expense->delete();
        return back()->with('success', 'Expense removed successfully.');
    }
}
