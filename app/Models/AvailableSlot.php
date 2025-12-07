<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableSlot extends Model
{
    protected $fillable = ['provider_id', 'date', 'start_time', 'end_time'];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}