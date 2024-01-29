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
                'imagen' => 'https://fincamonterruiz.s3.eu-north-1.amazonaws.com/public/images/imagen1.jpg',
                'activa' => true,
            ],
            [
                'nombre' => 'Visita al viñedo 2',
                'descripcion' => 'Descripción de la actividad 2',
                'duracion' => 120,
                'precio_adulto' => 20.00,
                'precio_nino' => 10.00,
                'aforo' => 50,
                'imagen' => 'https://fincamonterruiz.s3.eu-north-1.amazonaws.com/public/images/imagen2.jpg',
                'activa' => true,
            ],
            [
                'nombre' => 'Visita al viñedo 3',
                'descripcion' => 'Descripción de la actividad 3',
                'duracion' => 120,
                'precio_adulto' => 20.00,
                'precio_nino' => 10.00,
                'aforo' => 50,
                'imagen' => 'https://fincamonterruiz.s3.eu-north-1.amazonaws.com/public/images/imagen3.jpg',
                'activa' => true,
            ]
        ];

        if (isset($actividad['imagen'])) {
            // Asume que tienes un archivo local en `storage/app/public/img/` con el nombre de imagen especificado
            $localImagePath = storage_path('app/public/' . $actividad['imagen']);

            if (file_exists($localImagePath)) {
                $fileContent = file_get_contents($localImagePath);
                $imageName = basename($actividad['imagen']);
                $s3Path = 'public/images/' . $imageName;

                // Subir la imagen a S3
                Storage::disk('s3')->put($s3Path, $fileContent, 'public');

                // Obtener la URL pública de la imagen subida y actualizar el array de actividad
                $actividad['imagen'] = Storage::disk('s3')->url($s3Path);
            } else {
                // Si el archivo no existe, puedes decidir qué hacer: omitir la imagen, usar una imagen predeterminada, etc.
                unset($actividad['imagen']); // Omitir la imagen si no existe
            }
        }

        // Insertar datos en la tabla de actividades
        foreach ($actividades as $actividad) {
            Actividad::create($actividad);
        }
    }
}
