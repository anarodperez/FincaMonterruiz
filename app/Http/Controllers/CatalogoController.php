<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Actividad;
use App\Models\Horario;


class CatalogoController extends Controller
{

    public function index()
    {
        // Obtiene todos los horarios con su actividad relacionada
        $horarios = Horario::with('actividad')->get();

        // Obtiene solo las actividades que están activas
        $actividades = Actividad::where('activa', true)->get();

        $events = $horarios->map(function ($horario) {
            return [
                'title' => $horario->actividad->nombre, // Asumiendo que la actividad tiene un campo 'nombre'
                'start' => $horario->fecha . 'T' . $horario->hora,
                'extendedProps' => [
                    'idioma' => $horario->idioma,
                    'horario_id' => $horario->id,
                    'frecuencia' => $horario->frecuencia, // Añade la frecuencia aquí
                ],
            ];
        });

        return view('pages.catalogo', compact('events', 'actividades'));
    }

    public function buscar(Request $request)
{
    try {
        $query = $request->get('q');
        $normalizedQuery = $this->normalizeString($query);

        $actividades = Actividad::where('activa', true)
                                 ->whereRaw("unaccent(lower(nombre)) LIKE unaccent(lower(?))", ['%' . $normalizedQuery . '%'])
                                 ->get();

        return response()->json($actividades);
    } catch (\Exception $e) {
        \Log::error('Error en buscar:', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Error interno del servidor'], 500);
    }
}


protected function normalizeString($string)
{
    $string = mb_strtolower($string, 'UTF-8'); // Usa mb_strtolower para soporte de caracteres multibyte
    $replacements = [
        'á' => 'a',
        'é' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ú' => 'u',
    ];

    $string = strtr($string, $replacements); // Usa strtr para reemplazar los caracteres

    return $string;
}


// public function filter(Request $request)
//     {
//         $precio = $request->input('precio');

//         // Aquí, debes definir la lógica para determinar los rangos de precios
//         // Por ejemplo, 'bajo' podría ser de 0 a 20 euros, 'medio' de 21 a 50, etc.

//         $query = Actividad::query();

//         if ($precio == 'bajo') {
//             $query->where('precio_adulto', '<=', 20);
//         } elseif ($precio == 'medio') {
//             $query->whereBetween('precio_adulto', [21, 50]);
//         } elseif ($precio == 'alto') {
//             $query->where('precio_adulto', '>', 50);
//         }

//         $actividades = $query->get();

//         return view('pages.catalogo', compact('actividades'));
//     }


}
