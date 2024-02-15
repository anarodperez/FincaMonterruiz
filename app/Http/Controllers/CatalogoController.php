<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Actividad;
use App\Models\Horario;
use App\Models\Reserva;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;

class CatalogoController extends Controller
{
    private $hashids;

    public function __construct()
    {
        $HASHID_SALT = 'Albariza_9698_fincaM';
        // Inicializa Hashids con una sal secreta y una longitud mínima
        $this->hashids = new Hashids($HASHID_SALT, 10);
    }

    public function index()
    {
        // Recuperar horarios (no ocultos) de actividades
        $horarios = Horario::with('actividad')
        ->where('oculto', false)
        ->get();


        // Recuperar actividades que están activas y paginar los resultados
        $actividades = Actividad::where('activa', true)->paginate(3);

        // Preparar los eventos para el calendario o la lista de eventos en el frontend
        $events = $horarios
            ->filter(function ($horario) { // Filtrar para asegurar que cada horario tenga una actividad asociada
                return !is_null($horario->actividad);
            })
            ->map(function ($horario) { // Transformar cada horario en un formato adecuado para el frontend
                // Calcular plazas reservadas para la actividad
                $plazasReservadas = Reserva::where('actividad_id', $horario->actividad->id)
                    ->where('estado', 'confirmado') // Considerar solo reservas confirmadas
                    ->sum(DB::raw('num_adultos + num_ninos')); // Sumar el número de adultos y niños para obtener el total de plazas reservadas

                // Calcular las plazas disponibles restando las reservadas del aforo total
                $aforoDisponible = max(0, $horario->actividad->aforo - $plazasReservadas); // Asegurar que el número no sea negativo

                // Construir y retornar la estructura de datos para cada evento
                return [
                    'id' => $horario->actividad->id,
                    'title' => $horario->actividad->nombre,
                    'start' => $horario->fecha . 'T' . $horario->hora, // Combinar fecha y hora de inicio del evento
                    'extendedProps' => [ // Propiedades adicionales del evento
                        'idioma' => $horario->idioma,
                        'horario_id' => $this->hashids->encode($horario->id),
                        'frecuencia' => $horario->frecuencia,
                        'aforoDisponible' => $aforoDisponible,
                    ],
                ];
            });

        // Indicar que no se han aplicado filtros en la página de índice
        $filtrosAplicados = false;

        // Devolver la vista del catálogo con los datos de eventos, actividades y el estado de los filtros
        return view('pages.catalogo', compact('events', 'actividades', 'filtrosAplicados'));
    }


    public function buscar(Request $request)
    {
        try {
            // Obtener el término de búsqueda de la solicitud
            $query = $request->get('q');

            // Normalizar el término de búsqueda para hacerlo insensible a mayúsculas y acentos
            $normalizedQuery = $this->normalizeString($query);

            // Realizar la consulta a la base de datos para buscar actividades activas que coincidan con el término de búsqueda
            $actividades = Actividad::where('activa', true)
                ->whereRaw('unaccent(lower(nombre)) LIKE unaccent(lower(?))', ['%' . $normalizedQuery . '%'])
                ->get()
                ->map(function ($actividad) {
                    // Asegurar que la URL de la imagen sea absoluta para evitar problemas de ruta
                    $actividad->imagen = asset($actividad->imagen);
                    return $actividad;
                });

            // Devolver los resultados como JSON
            return response()->json($actividades);
        } catch (\Exception $e) {
            // Registrar el error en caso de una excepción y devolver un mensaje de error
            \Log::error('Error en buscar:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    protected function normalizeString($string)
    {
        // Convertir la cadena a minúsculas y reemplazar caracteres acentuados para normalizarla
        $string = mb_strtolower($string, 'UTF-8');
        $replacements = [
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
        ];

        $string = strtr($string, $replacements);

        return $string;
    }


    public function filter(Request $request)
    {
        // Validaciones
        $validatedData = $request->validate([
            'precio_max' => 'nullable|numeric|min:0|sometimes',
            'precio_min' => 'nullable|numeric|min:0|sometimes',
            'publico' => 'nullable|in:todos,adultos,ninos',
            'duracion' => 'nullable|in:corta,media,larga',
        ]);

        // Iniciar la consulta con la condición base
        $query = Actividad::where('activa', true);

       // Filtrar por precio mínimo solo para adultos --> verificar si un valor está presente en la solicitud y no está vacío.
    if ($request->filled('precio_min')) {
        $query->where('precio_adulto', '>=', $request->precio_min);
    }


    // Filtrar por precio máximo solo para adultos
    if ($request->filled('precio_max')) {
        $query->where('precio_adulto', '<=', $request->precio_max);
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

        $actividades = $query->paginate(3); //paginación


        $horarios = Horario::with('actividad')
        ->where('oculto', false)
        ->get();
        $events = $horarios->map(function ($horario) {
            return [
                'title' => $horario->actividad->nombre,
                'start' => $horario->fecha . 'T' . $horario->hora,
                'extendedProps' => [
                    'idioma' => $horario->idioma,
                    'horario_id' => $this->hashids->encode($horario->id),
                    'frecuencia' => $horario->frecuencia,
                ],
            ];
        });


        /// Determina si hay actividades después de aplicar filtros
        $hayResultados = $actividades->isNotEmpty();

        // verifica si se han aplicado filtros
        $filtrosAplicados = count(array_filter($request->all())) > 0;

        return view('pages.catalogo', [
            'actividades' => $actividades,
            'events' => $events,
            'filtros' => $request->all(),
            'hayResultados' => $hayResultados,
            'filtrosAplicados' => $filtrosAplicados,
        ]);
    }
}
