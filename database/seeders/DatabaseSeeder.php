<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creating the 'admin' role
        $adminRole = Role::factory()->create([
            'name' => 'admin',
        ]);

        // Creating the 'user' role
        $userRole = Role::factory()->create([
            'name' => 'user',
        ]);

        // Creating the 'admin' user
        $adminUser = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'type' => 1,
            'image' => fake()->imageUrl(), // This generates a placeholder image URL
            'password' => Hash::make('mamoon'),
        ]);

        // Creating the 'user' user
        $normalUser = User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'type' => 2,
            'image' => fake()->imageUrl(), // This generates a placeholder image URL
            'password' => Hash::make('mamoon'),
        ]);


        Category::factory()->create([
            'name' => 'Electronic',
            'image' => fake()->imageUrl(),
            'url' => fake()->url(),
        ]);

        Category::factory()->create([
            'name' => 'Grocery',
            'image' => fake()->imageUrl(),
            'url' => fake()->url(),
        ]);

        Product::factory(10)->create();

        // If you have relationships between users and roles, you can attach the roles to the users.
        // Example:
        // $adminUser->roles()->attach($adminRole->id);
        // $normalUser->roles()->attach($userRole->id);
    }
}
