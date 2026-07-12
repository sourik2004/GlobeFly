<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'address',
        'star_rating',
        'hotel_partner_id',
        'image_url',
    ];

    protected $casts = [
        'star_rating' => 'integer',
    ];

    public function partner()
    {
        return $this->belongsTo(User::class, 'hotel_partner_id');
    }

    public function rooms()
    {
        return $this->hasMany(HotelRoom::class);
    }
}
