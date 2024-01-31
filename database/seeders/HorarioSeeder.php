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
        // Asegúrate de que exista al menos una actividad en la base de datos
        $actividad = Actividad::first(); // Obtiene la primera actividad

        if ($actividad) {
            // Si existe una actividad, crea un horario para ella
            $horario = new Horario([
                'fecha' => Carbon::now()->format('Y-m-d'),
                'hora' => '10:00:00',
                'idioma' => 'Español',
                // Usa el id de la actividad obtenida
                'actividad_id' => $actividad->id,
            ]);
            $horario->save();
        } else {
            // Opcional: Puedes manejar el caso de que no existan actividades
            // Por ejemplo, lanzando una excepción o creando una actividad predeterminada
            // throw new \Exception('No hay actividades disponibles para asignar horarios');
        }
    }
}
