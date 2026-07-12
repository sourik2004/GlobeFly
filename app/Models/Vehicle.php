<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'name',
        'type',
        'price_per_day',
        'capacity',
        'provider_name',
        'is_available',
        'image_url',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'capacity' => 'integer',
        'is_available' => 'boolean',
    ];

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
