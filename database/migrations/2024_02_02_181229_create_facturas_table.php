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
            $table->unsignedBigInteger('reserva_id'); // Referencia a la tabla de reservas
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');
            $table->decimal('monto', 10, 2); // Monto total de la factura
            $table->string('estado', 20)->default('emitida'); // Estado de la factura (emitida, pagada, cancelada, etc.)
            $table->text('detalles')->nullable(); // Detalles adicionales de la factura
            $table->dateTime('fecha_emision'); // Fecha de emisión de la factura
            $table->dateTime('fecha_cancelacion')->nullable(); // Fecha de cancelación de la factura, si aplica
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
