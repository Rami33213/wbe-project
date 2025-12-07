<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\ServiceCategory;

class CategorySeeder extends Seeder
{
    public function run()
    {
        ServiceCategory::create(['name' => 'Car Services']);
        ServiceCategory::create(['name' => 'Home Cleaning']);
    }
}
