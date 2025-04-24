<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        Brand::create([
            'name' => 'Dell'
        ]);

        Brand::create([
            'name' => 'HP'
        ]);

        Brand::create([
            'name' => 'Lenovo'
        ]);

        Brand::create([
            'name' => 'Apple Store'
        ]);
    }
}
