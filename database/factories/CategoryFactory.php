<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // $table->id();
            // $table->string('name');
            // $table->string('image');
            // $table->string('url');
            // $table->timestamps();
            'name' => fake()->name(),
            'image' => fake()->imageUrl(),
            'url' => fake()->url(),
        ];
    }
}
