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


    // Obtiene solo las actividades que están activas con paginación
    $actividades = Actividad::where('activa', true)->paginate(3);


        $events = $horarios->map(function ($horario) {
            return [
                'id' => $horario->actividad->id,
                'title' => $horario->actividad->nombre,
                'start' => $horario->fecha . 'T' . $horario->hora,
                'extendedProps' => [
                    'idioma' => $horario->idioma,
                    'horario_id' => $horario->id,
                    'frecuencia' => $horario->frecuencia,
                    'aforo' => $horario->actividad->aforo,
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
                                ->get()
                                ->map(function ($actividad) {
                                    // Asegúrate de que la imagen tenga la URL completa
                                    $actividad->imagen = asset( $actividad->imagen);
                                    return $actividad;
                                });

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


public function filter(Request $request)
{
    // Validaciones
    $validatedData = $request->validate([
        'precio_min' => 'nullable|numeric|min:0',
        'precio_max' => 'nullable|numeric|min:0|gte:precio_min',
        'publico' => 'nullable|in:todos,adultos,ninos',
        'duracion' => 'nullable|in:corta,media,larga',
    ]);

    // Iniciar la consulta con la condición base
    $query = Actividad::where('activa', true);

    // Filtrar por precio mínimo
    if ($request->filled('precio_min')) {
        $query->where(function ($q) use ($request) {
            $q->where('precio_adulto', '>=', $request->precio_min)
              ->orWhere('precio_nino', '>=', $request->precio_min);
        });
    }

    // Filtrar por precio máximo
    if ($request->filled('precio_max')) {
        $query->where(function ($q) use ($request) {
            $q->where('precio_adulto', '<=', $request->precio_max)
              ->orWhere('precio_nino', '<=', $request->precio_max);
        });
    }

    // Filtro por público objetivo
    if ($request->filled('publico')) {
        switch ($request->publico) {
            case 'todos':
                $query->whereNotNull('precio_adulto')->whereNotNull('precio_nino');
                break;
            case 'adultos':
                $query->whereNotNull('precio_adulto')->whereNull('precio_nino');
                break;
            case 'ninos':
                $query->whereNull('precio_adulto')->whereNotNull('precio_nino');
                break;
        }
    }

    // Filtro por duración
    if ($request->filled('duracion')) {
        switch ($request->duracion) {
            case 'corta':
                $query->where('duracion', '<', 60);
                break;
            case 'media':
                $query->whereBetween('duracion', [60, 120]);
                break;
            case 'larga':
                $query->where('duracion', '>', 120);
                break;
        }
    }


    $actividades = $query->get();
    $horarios = Horario::with('actividad')->get();
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

    $actividades = $query->paginate(3); // Aplicar paginación aquí

    return view('pages.catalogo', [
        'actividades' => $actividades,
        'events' => $events,
        'filtros' => $request->all() // Pasar todos los valores de los filtros
    ]);


}



}
