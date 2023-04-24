<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
class ImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'unit_id' => fake()->numberBetween($min = 1, $max = 500),
            'imag' => [
                fake()->imageUrl(),
                fake()->imageUrl(),
                fake()->imageUrl(),
            ],
        ];
    }
}
