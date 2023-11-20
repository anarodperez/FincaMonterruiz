<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario;
use App\Models\Actividad;
use Faker;

class HorarioSeeder extends Seeder
{
    public function run()
    {
        // Usar el generador de datos Faker
        $faker = \Faker\Factory::create();

        // Obtener todas las actividades existentes
        $actividades = Actividad::all();

        // Crear horarios de prueba
        foreach ($actividades as $actividad) {
            for ($i = 0; $i < 5; $i++) {
                Horario::create([
                    'fecha' => $faker->date,
                    'hora' => $faker->time,
                    'actividad_id' => $actividad->id,
                    'plazas_disponibles' => $faker->numberBetween(1, 20),
                    'idioma' => $faker->randomElement(['Español', 'Inglés', 'Francés']),
                ]);
            }
        }

    }
}

