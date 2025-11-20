<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            // unique SKU: SKU-0001 style
            'sku' => 'SKU-' . $this->faker->unique()->numerify('####'),
            'name' => $this->faker->words(2, true), // contoh: "Sticky Notes"
            // randomFloat(decimals, min, max)
            'price' => $this->faker->randomFloat(2, 100, 100000),
            'stock_quantity' => $this->faker->numberBetween(0, 500),
            'reserved_quantity' => $this->faker->numberBetween(0, 50),
        ];
    }

    /**
     * Contoh state: stock yang kosong
     */
    public function outOfStock()
    {
        return $this->state(fn(array $attributes) => [
            'stock_quantity' => 0,
            'reserved_quantity' => 0,
        ]);
    }
}
