<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'bookable_type',
        'bookable_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'special_requests',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'bookable_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookable()
    {
        return $this->morphTo();
    }
}
