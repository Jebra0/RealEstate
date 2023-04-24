<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
          \App\Models\User::factory(500)->create();
          \App\Models\ParentUnit::factory(500)->create();
          \App\Models\Unit::factory(500)->create();
          \App\Models\Image::factory(500)->create();
          \App\Models\feature::factory(500)->create();


    }
}
