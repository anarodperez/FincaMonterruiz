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
        Schema::table('reservas', function (Blueprint $table) {
             $table->string('paypal_sale_id')->nullable(); // ID de la transacción de PayPal
             $table->decimal('total_pagado', 8, 2)->nullable(); //  total pagado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn('paypal_sale_id');
            $table->dropColumn('total_pagado');
        });
    }
};
