<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Newsletter;

class NewsletterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Crea la primera newsletter de bienvenida
         Newsletter::create([
            'id' => 1,
            'titulo' => '¡Bienvenido a nuestro boletín!',
            'contenido' => 'Gracias por suscribirte a nuestro boletín. Esperamos que disfrutes de nuestras actualizaciones y ofertas especiales.',
            'selected' => 'true'
        ]);
    }
}
