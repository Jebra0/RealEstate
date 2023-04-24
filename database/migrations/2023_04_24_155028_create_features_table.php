<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();

            $table->boolean('air_condition');
            $table->boolean('central_heating');
            $table->integer('bedrooms');
            $table->integer('living_rooms');
            $table->integer('bathroom');
            $table->integer('kitchen');
            $table->foreignId('unit_id')->references('id')->on('units');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
