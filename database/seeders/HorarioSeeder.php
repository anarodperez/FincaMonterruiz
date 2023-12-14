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
        // Borra los horarios existentes antes de recrearlos
        Horario::truncate();

        $horario = new Horario();
        $horario->fecha = '2023-12-18'; // Fecha de inicio
        $horario->hora = '10:00:00'; // Hora
        $horario->idioma = 'Español';
        $horario->actividad_id = 1; // ID de la actividad
        $horario->save();

        // Llama al método para crear fechas recurrentes
        $horario->getFechasRecurrentes();
    }
}
