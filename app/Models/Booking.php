<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'provider_id',
        'service_id',
        'date',
        'start_time',
        'end_time',
        'address_text',
        'city',
        'area',
        'approx_price',
        'status',
        'reject_reason',
        'notes',
        'cancel_deadline_hours',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function logs()
    {
        return $this->hasMany(BookingLog::class, 'booking_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'booking_id');
    }
}
