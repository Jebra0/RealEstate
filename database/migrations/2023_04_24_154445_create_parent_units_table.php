<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parent_units', function (Blueprint $table) {
            $table->id();


            $table->integer('total_floor');
            $table->integer('num_of_units');
            $table->string('parent_name');
            $table->boolean('has_elevator')->default(1);
            $table->string('street_name');
            $table->string('city_name');
            $table->string('state_name');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_units');
    }
};
