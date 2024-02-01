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
         // Vaciar la tabla primero si es necesario
         DB::table('reservas')->delete();

        // Asegúrate de que existen la actividad, el horario y el usuario necesarios.
        if (Actividad::exists() && Horario::exists() && User::where('id', 2)->exists()) {
            $reservasData = [];
            $horarioId = Horario::first()->id;
            $actividadId = Actividad::first()->id;
            $userId = 2;

            for ($i = 0; $i < 3; $i++) {
                $reservasData[] = [
                    'num_adultos' => rand(1, 5),
                    'num_ninos' => rand(0, 5),
                    'observaciones' => 'Reserva de prueba ' . ($i + 1),
                    'horario_id' => $horarioId,
                    'actividad_id' => $actividadId,
                    'user_id' => $userId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            DB::table('reservas')->insert($reservasData);
        } else {
            echo "Necesitas al menos una actividad, un horario y un usuario con ID 2 en la base de datos.\n";
        }
    }
}
