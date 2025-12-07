<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
$this->call([
        AdminUserSeeder::class,
        UserSeeder::class,
        CategorySeeder::class,   // ✅ لازم يجي قبل ServiceSeeder
        ServiceSeeder::class,
        BookingSeeder::class,
        ReviewSeeder::class,
    ]);
}
    
}
