<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
class UnitFactory extends Factory
{
    public function definition(): array
    {
        $roomTypes =['appartment', 'sallon', 'Home'];
        $for = [ 'Rent', 'sale'];
        return [
            'description' => fake()->text(),
            'price' => fake()->numberBetween($min = 3000, $max = 100000),
            'type' => fake()->randomElement($roomTypes),
            'for_what' => fake()->randomElement($for),
            'date_of_posting' => fake()->date(),
            'is_available' => fake()->boolean(),
            'posted_by' => fake()->numberBetween($min = 521, $max = 771),
            'parent_unit_id' => fake()->numberBetween($min = 1002, $max = 1252),
        ];
    }
}
