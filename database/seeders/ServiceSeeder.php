<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        Service::create([
            'provider_id' => 2, // ID المزود من UserSeeder
            'category_id' => 1, // Car Services
            'name' => 'Car Wash',
            'description' => 'Full wash inside and outside',
            'price_min' => 50,
            'price_max' => 80,
            'duration_minutes' => 90,
            'is_active' => true,
        ]);
    }
}
