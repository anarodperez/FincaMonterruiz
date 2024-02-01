<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\Valoracion;
use Illuminate\Support\Facades\DB;

class ValoracionesSeeder extends Seeder
{
    public function run(): void
    {
        // Vaciar la tabla primero si es necesario
        DB::table('valoraciones')->delete();

        // Obtiene las reservas realizadas por el usuario con ID 2
        $reservas = Reserva::where('user_id', 2)->get();

        if ($reservas->isEmpty()) {
            echo "No se encontraron reservas para el usuario con ID 2.\n";
            return;
        }

        // Asegúrate de tener suficientes comentarios únicos para las reservas
        $comentarios = [
            'Una experiencia inolvidable, ¡volveremos!',
            'Excelente guía y un vino delicioso. Recomendado totalmente.',
            'Hermoso lugar y gran aprendizaje sobre el proceso del vino.',
            'La cata de vinos fue educativa y entretenida, gracias por todo.',
            'Los aperitivos estaban deliciosos y combinaban perfectamente con los vinos.'
        ];

        if (count($reservas) > count($comentarios)) {
            echo "No hay suficientes comentarios únicos para el número de reservas.\n";
            return;
        }

        // Mezclar los comentarios para añadir variedad al orden en que se asignan
        shuffle($comentarios);

        foreach ($reservas as $reserva) {
            // Obtener y remover el comentario del inicio del arreglo
            $comentario = array_shift($comentarios);

            Valoracion::create([
                'user_id' => $reserva->user_id,
                'actividad_id' => $reserva->actividad_id,
                'puntuacion' => rand(3, 5),
                'comentario' => $comentario,
            ]);
        }
    }
}
