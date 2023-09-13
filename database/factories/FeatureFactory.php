<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'air_condition' => fake()->boolean(),
            'central_heating' => fake()->boolean(),
            'bedrooms' => fake()->numberBetween(0, 4),
            'living_rooms' => fake()->numberBetween(0, 4),
            'bathroom' => fake()->numberBetween(0, 4),
            'kitchen' => fake()->numberBetween(0, 4),
            'unit_id' => fake()->unique()->numberBetween($min = 16, $max = 1017),

        ];
    }
}
