<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ParentUnitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'total_floor' => fake()->numberBetween(1, 15),
            'num_of_units' => fake()->numberBetween(1, 50),
            'parent_name' => fake()->streetName(),
            'has_elevator' => fake()->boolean(),
            'street_name' => fake()->streetName(),
            'city_name' => fake()->city(),
            'state_name' => fake()->text(),
        ];
    }
}
