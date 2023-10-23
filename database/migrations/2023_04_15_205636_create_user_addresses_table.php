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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street_name');
            $table->string('building_number');
            $table->string('floor_number');
            $table->string('flat_number');
            $table->boolean('is_main')->default(false);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('area_id')->constrained('areas');
            $table->unique(['user_id', 'is_main'], 'unique_user_addresses_is_main');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
