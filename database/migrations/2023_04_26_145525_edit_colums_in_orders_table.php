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
        Schema::table('orders', function (Blueprint $table) {
            //$table->dropColumn('prescription');
            $table->dropForeign('orders_pharmacy_id_foreign');
            $table->dropColumn('pharmacy_id');
            $table->dropForeign('orders_doctor_id_foreign');
            $table->dropColumn('doctor_id');
        });
    }

    /**
     * Reverse the migrations.
     */


};
