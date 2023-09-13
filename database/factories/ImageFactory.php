<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
class ImageFactory extends Factory
{
    public function definition(): array
    {
        $url = [
            'UNIT1.jpg',
            'UNIT2.jpg',
            'UNIT3.jpg',
            'UNIT4.jpg',
            'UNIT5.jpg',
        ];
        return [
            'unit_id' => fake()->numberBetween($min = 16, $max = 1017),
            'imag' => fake()->randomElement($url),

        ];
    }
}
