<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\Actividad;
use App\Models\Horario;
use Illuminate\Support\Facades\DB;


class ReservasSeeder extends Seeder

{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Asegúrate de tener al menos una actividad y un horario creados
         $actividad = Actividad::first(); // Obtiene la primera actividad
         $horario = Horario::first(); // Obtiene el primer horario

         if (!$actividad || !$horario) {
             echo "Por favor, asegúrate de tener al menos una actividad y un horario en la base de datos.\n";
             return;
         }

         // Crear 3 reservas
         for ($i = 0; $i < 3; $i++) {
             Reserva::create([
                 'num_adultos' => rand(1, 5), // Número aleatorio de adultos
                 'num_ninos' => rand(0, 5), // Número aleatorio de niños
                 'observaciones' => 'Reserva de prueba ' . ($i + 1),
                 'horario_id' => $horario->id, // Asume que todas las reservas son para el mismo horario
                 'actividad_id' => $actividad->id, // Asume que todas las reservas son para la misma actividad
                 'user_id' => 1, // Asume que el usuario con ID 1 realiza todas las reservas
             ]);
         }

    }
}
