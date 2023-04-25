<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('features', function (Blueprint $table) {
            $table->unique('unit_id');
            // $table->foreignId('unit_id')->unique()->references('id')->on('units')->change();
        });
    }

    public function down(): void
    {
        Schema::table('features', function (Blueprint $table) {
            //
        });
    }
};
