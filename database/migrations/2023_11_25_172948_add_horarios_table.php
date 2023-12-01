<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->time('hora');
            $table->enum('dia_semana', ['lunes', 'martes', 'miércoles', 'jueves', 'viernes','sábado','domingo']);
            $table->string('idioma');
            $table
                ->foreignId('actividad_id')
                ->constrained('actividades')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
