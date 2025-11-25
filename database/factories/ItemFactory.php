<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Pest\Support\Str;

class ItemFactory extends Factory
{
    public function definition()
    {
        return [
            'category_id' => Category::factory(),
            'sku' => strtoupper(Str::random(3)) . '-' . $this->faker->unique()->numerify('###'),
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock_quantity' => $this->faker->numberBetween(0, 500),
            'description' => $this->faker->optional()->sentence(),
        ];
    }
}
