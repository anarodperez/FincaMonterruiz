<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario;
use App\Models\Actividad;

class HorarioSeeder extends Seeder
{
    public function run()
    {
        // Obtener algunas actividades existentes
        $actividades = Actividad::limit(5)->get();

        // Crear horarios de prueba
        foreach ($actividades as $actividad) {
            Horario::create([
                'dias_semana' => 'Lunes',
                'hora' => '12:00:00',
                'actividad_id' => $actividad->id,
                'plazas_disponibles' => 15,
                'idioma' => 'Español',
            ]);

            Horario::create([
                'dias_semana' => 'Miércoles',
                'hora' => '14:30:00',
                'actividad_id' => $actividad->id,
                'plazas_disponibles' => 20,
                'idioma' => 'Inglés',
            ]);

            // Agrega más horarios según tus necesidades
        }
    }
}
