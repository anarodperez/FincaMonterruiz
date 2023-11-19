<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('horarios', function (Blueprint $table) {
            // Eliminar el campo 'fecha'
            $table->dropColumn('fecha');

            // Agregar el nuevo campo 'dias_semana'
            $table->string('dias_semana')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('horarios', function (Blueprint $table) {
            // Revertir la migración: agregar el campo 'fecha' y eliminar 'dias_semana'
            $table->dateTime('fecha')->after('id');
            $table->dropColumn('dias_semana');
        });
    }
};
