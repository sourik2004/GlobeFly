<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'destination',
        'start_date',
        'end_date',
        'budget',
        'preferences',
        'itinerary_data',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'preferences' => 'array',
        'itinerary_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
