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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_insured')->default(false);
            $table->json('prescription');
            $table->enum('status', ['New', 'Processing', 'Waiting', 'Canceled', 'Confirmed', 'Delivered']);
            $table->foreignId('pharmacy_id')->nullable()->constrained('pharmacies');
            $table->foreignId('doctor_id')->nullable()->constrained('doctors');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('address_id')->constrained('user_addresses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
