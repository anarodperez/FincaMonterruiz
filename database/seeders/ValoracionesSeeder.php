<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Valoracion;
use App\Models\Reserva;
use App\Models\User;

class ValoracionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Obtiene las reservas realizadas por el usuario con ID 2
         $reservas = Reserva::where('user_id', 2)->get();

         if ($reservas->isEmpty()) {
             echo "No se encontraron reservas para el usuario con ID 2.\n";
             return;
         }

         // Crear valoraciones para cada actividad por diferentes usuarios
         foreach ($reservas as $reserva) {
                 Valoracion::create([
                    'user_id' => $reserva->user_id, // Usuario que hizo la reserva
                    'actividad_id' => $reserva->actividad_id, // Actividad reservada
                    'puntuacion' => rand(1, 5), // Puntuación aleatoria entre 1 y 5
                    'comentario' => 'Comentario de ejemplo para la actividad ' . $reserva->actividad_id . ' reservada por el usuario ' . $reserva->user_id,
                 ]);
         }
    }
}
