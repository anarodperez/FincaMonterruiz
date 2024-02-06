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
        $horarios = Horario::with('actividad')
        ->whereDoesntHave('actividad', function ($query) {
            $query->where('oculto', true);
        })
        ->get();
        $actividades = Actividad::where('activa', true)->paginate(3);

        $events = $horarios
            ->filter(function ($horario) {
                return !is_null($horario->actividad);
            })
            ->map(function ($horario) {
                // Calcular las plazas reservadas para esta actividad
                $plazasReservadas = Reserva::where('actividad_id', $horario->actividad->id)
                    ->where('estado', 'confirmado')
                    ->sum(DB::raw('num_adultos + num_ninos'));

                // Calcular las plazas disponibles
                $aforoDisponible = max(0, $horario->actividad->aforo - $plazasReservadas);

                return [
                    'id' => $horario->actividad->id,
                    'title' => $horario->actividad->nombre,
                    'start' => $horario->fecha . 'T' . $horario->hora,
                    'extendedProps' => [
                        'idioma' => $horario->idioma,
                        'horario_id' => $this->hashids->encode($horario->id),
                        'frecuencia' => $horario->frecuencia,
                        'aforoDisponible' => $aforoDisponible,
                        'idioma' => $horario->idioma,
                    ],
                ];
            });

        // En el index, no se han aplicado filtros todavía
        $filtrosAplicados = false;
        return view('pages.catalogo', compact('events', 'actividades', 'filtrosAplicados'));
    }

    public function buscar(Request $request)
    {
        try {
            $query = $request->get('q');
            $normalizedQuery = $this->normalizeString($query);

            $actividades = Actividad::where('activa', true)
                ->whereRaw('unaccent(lower(nombre)) LIKE unaccent(lower(?))', ['%' . $normalizedQuery . '%'])
                ->get()
                ->map(function ($actividad) {
                    // Asegúrate de que la imagen tenga la URL completa
                    $actividad->imagen = asset($actividad->imagen);
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
        $string = mb_strtolower($string, 'UTF-8'); // mb_strtolower para soporte de caracteres multibyte
        $replacements = [
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
        ];

        $string = strtr($string, $replacements); // strtr para reemplazar los caracteres

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

       // Filtrar por precio mínimo solo para adultos
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


        $horarios = Horario::with('actividad')->get();
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
