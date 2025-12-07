<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        Review::create([
            'customer_id' => 3, // Test Customer
            'provider_id' => 2, // Test Provider
            'service_id'  => 1, // Car Wash
            'booking_id'  => 1, // BookingSeeder
            'rating'      => 5,
            'comment'     => 'خدمة ممتازة، السيارة صارت نظيفة ومرتبة 👍',
        ]);
    }
}
