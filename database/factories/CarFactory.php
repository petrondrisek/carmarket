<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'brand_id' => Brand::inRandomOrder()->value('id') ?? Brand::factory(),
            'model' => fake()->word(),
            'color' => fake()->colorName(),
            'locationLat' => fake()->randomFloat(6, 48, 51),
            'locationLng' => fake()->randomFloat(6, 12, 18),
            'kilometers' => fake()->randomFloat(2, 0, 100000),
            'price' => fake()->randomFloat(2, 0, 100000),
            'transmission' => fake()->randomElement(['manual', 'automatic']),
            'year' => fake()->year(),
            'fuel_consumption' => fake()->randomFloat(2, 0, 100),
            'description' => fake()->sentence(),
            'engine' => fake()->randomElement(['diesel', 'gasoline', 'hybrid', 'electric', 'lpg', 'cng']),
            'state' => fake()->randomElement(['new', 'used', 'refurbished']),
            'is_sold' => fake()->boolean(),
        ];
    }
}
