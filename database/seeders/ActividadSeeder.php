<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actividad;
use Illuminate\Support\Facades\DB;

class ActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Vaciar la tabla primero si es necesario
         DB::table('actividades')->delete();

        $actividades = [
            [
                'nombre' => 'Cata a ciegas',
                'descripcion' => '¡Experimenta el misterio de los sabores donde probarás una selección sorpresa de vinos de alta calidad
                                 sin conocer su etiqueta ni origen. ¡Descubre la magia de degustar sin prejuicios!',
                'duracion' => 90,
                'precio_adulto' => 20.0,
                'precio_nino' => null,
                'aforo' => 20,
                'imagen' => 'https://fincamonterruiz.s3.eu-north-1.amazonaws.com/public/images/imagen1.jpg',
                'activa' => true,
            ],
            [
                'nombre' => 'Visita al viñedo',
                'descripcion' => 'Disfruta de un relajante paseo por nuestros viñedos. Aprende sobre el proceso de cultivo y cosecha de la uva mientras disfrutas del paisaje natural.',
                'duracion' => 60,
                'precio_adulto' => 15.0,
                'precio_nino' => 7.50,
                'aforo' => 30,
                'imagen' => 'https://fincamonterruiz.s3.eu-north-1.amazonaws.com/public/images/imagen2.jpg',
                'activa' => true,
            ],
            [
                'nombre' => 'Cata y aperitivos',
                'descripcion' => 'Explora una experiencia sensorial excepcional con una selección de vinos y aperitivos, aprendiendo a maridarlos de manera experta para resaltar y disfrutar al máximo de sus sabores.',
                'duracion' => 90,
                'precio_adulto' => 30.0,
                'precio_nino' => null,
                'aforo' => 20,
                'imagen' => 'https://fincamonterruiz.s3.eu-north-1.amazonaws.com/public/images/imagen3.jpg',
                'activa' => true,
            ],
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
