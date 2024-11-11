<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('license')->unique();
            $table->string('brand');
            $table->string('category');
            $table->unsignedInteger('kilometers');
            $table->unsignedInteger('dailyfee');
            $table->unsignedInteger('last_maintenance');
            $table->unsignedInteger('next_maintenance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
