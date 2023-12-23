<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Relación con la tabla actividades
            $table->foreignId('actividad_id')
                  ->constrained('actividades')
                  ->onDelete('cascade');

            // Información del horario
            $table->date('fecha'); // Fecha de la actividad
            $table->time('hora');  // Hora de la actividad
            $table->string('idioma');

            // Campos para la frecuencia y repeticiones
            $table->string('frecuencia')->default('unico'); // Puede ser 'unico', 'diario', 'semanal'
            $table->integer('repeticiones')->nullable(); // Número de repeticiones para horarios recurrentes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
