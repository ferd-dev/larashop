<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Computers',
        ]);

        Category::create([
            'name' => 'Laptops',
        ]);

        Category::create([
            'name' => 'Desktops & All-in-Ones',
        ]);

        Category::create([
            'name' => 'Tablets',
        ]);
    }
}
