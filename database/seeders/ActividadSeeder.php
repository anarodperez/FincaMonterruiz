<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actividad;

class ActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Array de datos de ejemplo para actividades
        $actividades = [
            [
                'nombre' => 'Visita al viñedo 1',
                'descripcion' => 'Descripción de la actividad 1',
                'duracion' => 120,
                'precio_adulto' => 20.00,
                'precio_nino' => 10.00,
                'aforo' => 50,
                'imagen' => 'storage/img/img4.jpg',
                'activa' => true,
            ],
            [
                'nombre' => 'Visita al viñedo 2',
                'descripcion' => 'Descripción de la actividad 2',
                'duracion' => 120,
                'precio_adulto' => 20.00,
                'precio_nino' => 10.00,
                'aforo' => 50,
                'imagen' => 'storage/img/img1.jpg',
                'activa' => true,
            ],
            // Puedes agregar más actividades aquí
        ];

        // Insertar datos en la tabla de actividades
        foreach ($actividades as $actividad) {
            Actividad::create($actividad);
        }
    }
}
