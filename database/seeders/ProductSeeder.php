<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'title' => 'In elit eiusmod irure enim.',
            'price' => 100.00,
            'quantity' => 10,
            'description' => 'Id deserunt occaecat occaecat pariatur. Exercitation elit excepteur pariatur aliquip cillum nostrud fugiat nulla. Aute occaecat velit irure nulla aliqua officia occaecat. Ipsum ex non consequat nostrud consequat irure. Veniam consequat eu exercitation reprehenderit qui ad laborum nisi nostrud. Sit sunt dolor qui non aliquip fugiat incididunt veniam eiusmod labore consectetur pariatur pariatur.',
            'category_id' => 1,
            'brand_id' => 1,
        ]);
    }
}
