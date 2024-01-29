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
        // Agregar nuevas columnas a la tabla 'newsletters'
        Schema::table('newsletters', function (Blueprint $table) {
            $table->string('imagen_url')->nullable(); // Asumiendo que quieres permitir newsletters sin imagen.
            $table->enum('estado_envio', ['pendiente', 'enviado', 'programado'])->default('pendiente');
        });

        // Crear la nueva tabla 'historial_newsletters'
        Schema::create('historial_newsletters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('newsletter_id')->constrained('newsletters')->onDelete('cascade');
            $table->string('titulo');
            $table->text('contenido');
            $table->string('imagen_url')->nullable();
            $table->timestamps();
        });
    }

      /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar las nuevas columnas de la tabla 'newsletters'
        Schema::table('newsletters', function (Blueprint $table) {
            $table->dropColumn('imagen_url');
            $table->dropColumn('estado_envio');
        });

        // Eliminar la tabla 'historial_newsletters'
        Schema::dropIfExists('historial_newsletters');
    }
};
