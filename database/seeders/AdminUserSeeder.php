<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'), 
                'phone' => '0999999999',
                'location_city' => 'دمشق',
                'location_area' => 'المزة',
                'role' => 'admin',
                'status' => 'active',
            ]
        );
    }
}