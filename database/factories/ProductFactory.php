<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $title = $this->faker->words(3, true);
        return [
            'title' => $title,
            'quantity' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'brand_id' => $this->faker->numberBetween(1, 10),
            'category_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
