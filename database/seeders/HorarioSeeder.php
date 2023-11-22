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
        Horario::truncate();

        $diasSemana = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes'];
        $horas = ['10:00:00', '14:00:00', '18:00:00'];

        $actividades = Actividad::all();

        // Número máximo de horarios por actividad
        $maxHorariosPorActividad = 5;

        foreach ($actividades as $actividad) {
            // Obtén una cantidad aleatoria de horarios para cada actividad
            $numHorarios = rand(1, $maxHorariosPorActividad);

            for ($i = 0; $i < $numHorarios; $i++) {
                $dia = $diasSemana[array_rand($diasSemana)];
                $hora = $horas[array_rand($horas)];

                Horario::create([
                    'actividad_id' => $actividad->id,
                    'dia_semana' => $dia,
                    'hora' => $hora,
                    'idioma' => 'Español',
                ]);
            }
        }
    }
}
