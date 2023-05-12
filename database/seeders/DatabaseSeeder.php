<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
          \App\Models\User::factory(500)->create();
          \App\Models\ParentUnit::factory(1000)->create();
          \App\Models\Unit::factory(1000)->create();
          \App\Models\Image::factory(1500)->create();
          \App\Models\feature::factory(1000)->create();


    }
}
