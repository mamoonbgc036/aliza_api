<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'description' => fake()->text(),
            'price' => fake()->numberBetween(50, 100),
            'old_price' => fake()->numberBetween(100, 200),
            'category_id' => fake()->numberBetween(1, 2),
            'created_by' => fake()->numberBetween(1, 2),
            'unit' => 'pc'
        ];
    }
}
