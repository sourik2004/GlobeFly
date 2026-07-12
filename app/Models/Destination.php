<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'location',
        'coordinates',
        'weather_info',
        'image_url',
    ];

    public function packages()
    {
        return $this->hasMany(TourPackage::class);
    }
}
