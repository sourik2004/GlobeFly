<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_days',
        'destination_id',
        'tour_manager_id',
        'image_url',
        'max_slots',
        'available_slots',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'max_slots' => 'integer',
        'available_slots' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'tour_manager_id');
    }

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
