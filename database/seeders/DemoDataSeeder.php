<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Review;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // زبون
        $customer = User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Test Customer',
                'password' => bcrypt('123456'),
                'role' => 'customer',
                'status' => 'active',
            ]
        );

        // مزود
        $provider = User::updateOrCreate(
            ['email' => 'provider@example.com'],
            [
                'name' => 'Test Provider',
                'password' => bcrypt('123456'),
                'role' => 'provider',
                'status' => 'active',
            ]
        );

        // خدمة
        $service = Service::updateOrCreate(
            ['name' => 'Car Wash'],
            [
                'name' => 'Car Wash',
                'description' => 'Full wash inside and outside',
                'price_min' => 50,
                'price_max' => 80,
                'duration_minutes' => 90,
                'provider_id' => $provider->id,
                'category_id' => 1,
                'is_active' => true,
            ]
        );

        // حجز (لازم نخزنه في متغير)
        $booking = Booking::updateOrCreate(
            ['customer_id' => $customer->id, 'service_id' => $service->id],
            [
                'provider_id' => $provider->id,
                'date' => now()->toDateString(),
                'start_time' => '10:00',
                'end_time' => '11:00',
                'status' => 'pending',
                'city' => 'Damascus',
                'area' => 'Kafr Sousa',
                'approx_price' => 50,
            ]
        );

       Review::updateOrCreate(
    ['customer_id' => $customer->id, 'booking_id' => $booking->id, 'rating' => 2],
    [
        'provider_id' => $provider->id,
        'service_id' => $service->id, // ✅ لازم نضيفه
        'comment' => 'خدمة سيئة للتجربة - سيتم حذفها من الأدمن',
    ]
);

Review::updateOrCreate(
    ['customer_id' => $customer->id, 'booking_id' => $booking->id, 'rating' => 5],
    [
        'provider_id' => $provider->id,
        'service_id' => $service->id, // ✅ نفس الشي
        'comment' => 'خدمة ممتازة، السيارة صارت نظيفة ومرتبة 👍',
    ]
);


    }
}
