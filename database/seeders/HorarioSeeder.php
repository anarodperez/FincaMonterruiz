<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actividad;
use App\Models\Horario;
use Carbon\Carbon;

class HorarioSeeder extends Seeder
{
    public function run()
{
    // Crear un horario inicial
    $horario = new Horario([
        'fecha' => Carbon::now()->format('Y-m-d'), // Fecha actual
        'hora' => '10:00:00',
        'idioma' => 'Español',
        'actividad_id' => 1, // Asegúrate de que este ID exista
    ]);
    $horario->save();

    // Guardar horarios recurrentes en la base de datos
    $horario->guardarFechasRecurrentesEnDB();
}

}
