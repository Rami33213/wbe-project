<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderProfile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'years_of_experience',
        'base_price',
        'covered_areas',
        'average_rating',
        'is_available',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
