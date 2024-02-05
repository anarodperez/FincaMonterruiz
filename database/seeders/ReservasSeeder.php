<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\Factura; // Asegúrate de importar el modelo Factura
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

        if (Actividad::exists() && Horario::exists() && User::where('id', 2)->exists()) {
            $horarioId = Horario::first()->id;
            $actividadId = Actividad::first()->id;
            $userId = 2;
            $actividad = Actividad::findOrFail($actividadId);

            for ($i = 0; $i < 3; $i++) {
                // Verificar si la actividad tiene precio para niños
                $tienePrecioNino = isset($actividad->precio_nino) && $actividad->precio_nino > 0;
                $numNinos = $tienePrecioNino ? rand(0, 5) : 0; // Asignar número de niños solo si hay precio para ellos

                // Crear la reserva
                $reserva = Reserva::create([
                    'num_adultos' => rand(1, 5),
                    'num_ninos' => $numNinos, // Usar la variable condicional aquí
                    'observaciones' => 'Reserva de prueba ' . ($i + 1),
                    'horario_id' => $horarioId,
                    'actividad_id' => $actividadId,
                    'user_id' => $userId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                // Calcular los totales para la factura
                $precioPorAdulto = $actividad->precio_adulto;
                $precioPorNino = $tienePrecioNino ? $actividad->precio_nino : 0;

                $totalSinIVA = $reserva->num_adultos * $precioPorAdulto + $reserva->num_ninos * $precioPorNino;
                $iva = $totalSinIVA * 0.21; // Suponiendo un 21% de IVA
                $totalConIVA = $totalSinIVA + $iva;

                // Crear la factura para la reserva
                Factura::create([
                    'reserva_id' => $reserva->id,
                    'monto' => $totalSinIVA,
                    'iva' => $iva,
                    'monto_total' => $totalConIVA,
                    'estado' => 'pagada',
                    'fecha_emision' => now(),
                    'precio_adulto_final' => $precioPorAdulto,
                    'precio_nino_final' => $precioPorNino, // Aquí podría ser cero si no hay precio para niños
                ]);
            }
        } else {
            echo "Necesitas al menos una actividad, un horario y un usuario con ID 2 en la base de datos.\n";
        }
    }

}
