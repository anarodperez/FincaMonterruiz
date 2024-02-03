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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reserva_id');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');
            $table->decimal('monto', 10, 2); // Monto total sin IVA
            $table->decimal('iva', 5, 2)->default(21.00); // IVA aplicado
            $table->decimal('monto_total', 10, 2); // Monto total con IVA
            $table->decimal('precio_adulto_final', 8, 2); // Precio por adulto en el momento de la reserva
            $table->decimal('precio_nino_final', 8, 2)->nullable(); // Precio por niño en el momento de la reserva, si aplica
            $table->string('estado', 20)->default('pagada'); // Estado de la factura
            $table->text('detalles')->nullable(); // Detalles adicionales
            $table->dateTime('fecha_emision'); // Fecha de emisión
            $table->dateTime('fecha_cancelacion')->nullable(); // Fecha de cancelación
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
