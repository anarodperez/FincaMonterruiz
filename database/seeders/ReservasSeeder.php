<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\Actividad;
use App\Models\Horario;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservasSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar si existe al menos una actividad y un horario
        $actividad = Actividad::first();
        $horario = Horario::first();
        $user = User::find(2); // Asegúrate de que el usuario con ID 2 existe

        if (!$actividad || !$horario || !$user) {
            // Considera usar Log::warning() o alguna otra forma de logging en lugar de echo si es un entorno de producción
            echo "Necesitas al menos una actividad, un horario y un usuario con ID 2 en la base de datos.\n";
            return;
        }

        $estados = ['pendiente', 'confirmada', 'cancelada'];

        for ($i = 0; $i < 3; $i++) {
            Reserva::create([
                'num_adultos' => rand(1, 5),
                'num_ninos' => rand(0, 5),
                'observaciones' => 'Reserva de prueba ' . ($i + 1),
                'horario_id' => $horario->id,
                'actividad_id' => $actividad->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
