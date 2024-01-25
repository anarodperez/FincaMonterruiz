<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Valoracion;
use App\Models\Actividad;
use App\Models\User;

class ValoracionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Asegúrate de que existan usuarios y actividades
         $usuarios = User::all();
         $actividades = Actividad::all();

         if ($usuarios->isEmpty() || $actividades->isEmpty()) {
             echo "Necesitas tener al menos un usuario y una actividad para crear valoraciones.\n";
             return;
         }

         // Crear valoraciones para cada actividad por diferentes usuarios
         foreach ($actividades as $actividad) {
             foreach ($usuarios as $usuario) {
                 Valoracion::create([
                     'user_id' => $usuario->id,
                     'actividad_id' => $actividad->id,
                     'puntuacion' => rand(1, 5), // Puntuación aleatoria entre 1 y 5
                     'comentario' => 'Comentario de ejemplo para la actividad ' . $actividad->id,
                 ]);
             }
         }
    }
}
