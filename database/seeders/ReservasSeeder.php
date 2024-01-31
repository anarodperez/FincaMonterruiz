<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\Actividad;
use App\Models\Horario;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

         // Definir estados de reserva
         $estados = ['pendiente', 'confirmada', 'cancelada']; // Agrega los estados deseados

         // Crear 3 reservas y asignarlas al usuario con ID 2
         for ($i = 0; $i < 3; $i++) {
            Reserva::create([
                'num_adultos' => rand(1, 5), // Número aleatorio de adultos
                'num_ninos' => rand(0, 5), // Número aleatorio de niños
                'observaciones' => 'Reserva de prueba ' . ($i + 1),
                'estado' => $estados[array_rand($estados)], // Estado aleatorio
                'horario_id' => $horario->id, // Asume que todas las reservas son para el mismo horario
                'actividad_id' => $actividad->id, // Asume que todas las reservas son para la misma actividad
                'user_id' => 2, // Asigna las reservas al usuario con ID 2
                // Omitimos 'paypal_sale_id' y 'total_pagado' asumiendo que pueden ser nulos o no requeridos inicialmente
            ]);
        }
    }
}
