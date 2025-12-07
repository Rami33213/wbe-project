<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;

class BookingSeeder extends Seeder
{
    public function run()
    {
        Booking::create([
            'customer_id' => 3, // Test Customer
            'provider_id' => 2, // Test Provider
            'service_id'  => 1, // Car Wash
            'date'        => now()->addDays(2)->toDateString(),
            'start_time'  => '14:00:00',
            'end_time'    => '15:00:00',
            'status'      => 'pending',
            'notes'       => 'Please confirm quickly',
        ]);
    }
}
