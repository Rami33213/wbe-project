<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
     protected $fillable = [
        'name',
        'description',
        'price_min',
        'price_max',
        'duration_minutes',
        'provider_id',
        'category_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_min' => 'float',
        'price_max' => 'float',
        'duration_minutes' => 'integer',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'service_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'service_id');
    }
}
