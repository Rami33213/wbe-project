<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'location_city',
        'location_area',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | علاقات المستخدم
    |--------------------------------------------------------------------------
    */

    // ملف بروفايل المزوّد
    public function providerProfile()
    {
        return $this->hasOne(ProviderProfile::class, 'user_id');
    }

    // الخدمات التي يقدمها المزوّد
    public function services()
    {
        return $this->hasMany(Service::class, 'provider_id');
    }

    // حجوزات الزبون
    public function customerBookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    // حجوزات المزوّد
    public function providerBookings()
    {
        return $this->hasMany(Booking::class, 'provider_id');
    }

    // التقييمات التي كتبها المستخدم (زبون)
    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    // التقييمات التي استلمها المزوّد
    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'provider_id');
    }

    // (اختصار) التقييمات التي تخص المزوّد
    public function reviews()
    {
        return $this->hasMany(Review::class, 'provider_id');
    }

    // أفعال الأدمن (إن وجدت)
    public function adminActions()
    {
        return $this->hasMany(AdminAction::class, 'admin_id');
    }
    // حجوزات المزوّد (للتوافق مع ProviderProfileService)
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'provider_id');
    }

}
