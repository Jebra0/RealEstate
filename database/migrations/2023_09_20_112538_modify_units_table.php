<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->foreignId('posted_by')->references('id')->on('users')->change()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('parent_unit_id')->references('id')->on('parent_units')->change()->cascadeOnDelete()->cascadeOnUpdate();
        });

    }


    public function down(): void
    {
        //
    }
};
