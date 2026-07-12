<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'trip_id',
        'user_id',
        'title',
        'amount',
        'category',
        'expense_date',
    ];

    protected $casts = [
        'trip_id' => 'integer',
        'user_id' => 'integer',
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
