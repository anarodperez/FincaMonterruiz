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
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->text('descripcion');
            $table->integer('duracion');
            $table->decimal('precio_adulto', 8, 2)->nullable(); // Modificado para aceptar NULL
            $table->decimal('precio_nino', 8, 2)->nullable();   // Modificado para aceptar NULL
            $table->integer('aforo');
            $table->string('imagen');
            $table->boolean('activa')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
