<?php

namespace Database\Seeders;

// database/seeders/HorariosSeeder.php

use Illuminate\Database\Seeder;
use App\Models\Actividad;
use App\Models\Horario;
use Carbon\Carbon;

class HorarioSeeder extends Seeder
{
    public function run()
    {


        // Días de la semana y horas de ejemplo
        $diasSemana = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes'];
        $horas = ['10:00:00', '14:00:00', '18:00:00'];

        // Obtener todas las actividades
        $actividades = Actividad::all();

        // Crear horarios de ejemplo para cada actividad en diferentes días y horas
        foreach ($actividades as $actividad) {
            foreach ($diasSemana as $dia) {
                foreach ($horas as $hora) {
                    Horario::create([
                        'actividad_id' => $actividad->id,
                        'dia_semana' => $dia,
                        'hora' => $hora,
                        'plazas_disponibles' => rand(5, 20),
                        'idioma' => 'Español', // Ejemplo de idioma
                    ]);
                }
            }
        }
    }
}
