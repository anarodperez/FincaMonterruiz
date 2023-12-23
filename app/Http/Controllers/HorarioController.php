<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Actividad;
use DateTime;
use Illuminate\Http\Request;
use Carbon\Carbon;


class HorarioController extends Controller
{
    public function index()
    {
        $horarios = Horario::with('actividad')->get(); // Obtiene todos los horarios con su actividad relacionada

        $events = $horarios->map(function ($horario) {
            return [
                'title' => $horario->actividad->nombre, // Asumiendo que la actividad tiene un campo 'nombre'
                'start' => $horario->fecha . 'T' . $horario->hora,
                'extendedProps' => [
                    'idioma' => $horario->idioma,
                    'horario_id' => $horario->id,
                ],
            ];
        });


        return view('admin.horarios.index', compact('events'));
    }


    public function create()
    {
        $actividades = Actividad::all();
        return view('admin.horarios.create', compact('actividades'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'actividad' => 'required|exists:actividades,id',
                'fecha' => 'required|date|after_or_equal:today',
                'hora' => 'required|date_format:H:i',
                'idioma' => 'required|in:Español,Inglés,Francés',
                'frecuencia' => 'required|in:unico,diario,semanal',
                'repeticiones' => 'nullable|numeric|min:1|required_if:frecuencia,diario,semanal',

            ]);

            $actividadId = $request->input('actividad');
            $fecha = $request->input('fecha');
            $hora = $request->input('hora');
            $idioma = $request->input('idioma');
            $frecuencia = $request->input('frecuencia');
            $repeticiones = $request->input('repeticiones', 1); // Valor por defecto en caso de ser único

            // Lógica para crear horarios
            switch ($frecuencia) {
                case 'unico':
                    $this->crearHorario($actividadId, $fecha, $hora, $idioma);
                    break;
                case 'diario':
                    $this->crearHorariosRecurrentes($actividadId, $fecha, $hora, $idioma, $frecuencia, $repeticiones);
                case 'semanal':
                    $this->crearHorariosRecurrentes($actividadId, $fecha, $hora, $idioma, $frecuencia, $repeticiones);
                    break;
            }
            return redirect()->route('admin.horarios.index')->with('success', 'Horario(s) creado(s) exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al crear horario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema al crear el horario')->withInput();
        }
    }
    private function crearHorario($actividadId, $fecha, $hora, $idioma)
    {
        $horario = new Horario();
        $horario->actividad_id = $actividadId;
        $horario->fecha = $fecha;
        $horario->hora = $hora;
        $horario->idioma = $idioma;
        $horario->frecuencia = 'unico';
        $horario->save();
    }
    private function crearHorariosRecurrentes($actividadId, $fechaInicio, $hora, $idioma, $frecuencia, $repeticiones)
    {
        $fecha = Carbon::parse($fechaInicio);
        for ($i = 0; $i < $repeticiones; $i++) {
            $horario = new Horario();
            $horario->actividad_id = $actividadId;
            $horario->fecha = $fecha->toDateString();
            $horario->hora = $hora;
            $horario->idioma = $idioma;
            $horario->frecuencia = $frecuencia;
            $horario->save();

            $frecuencia === 'diario' ? $fecha->addDay() : $fecha->addWeek();
        }
    }


private function crearHorarioUnico($actividadId, $fecha, $hora, $idioma)
{
    // Crea un horario único con los datos del formulario y guárdalo en la base de datos
    Horario::create([
        'actividad_id' => $actividadId,
        'fecha' => $fecha,
        'hora' => $hora,
        'idioma' => $idioma,
        // Otros campos según sea necesario
    ]);
}

private function crearHorariosDiarios($actividadId, $fecha, $hora, $idioma, $repeticiones)
{
    // Crea horarios diarios a partir de la fecha seleccionada
    for ($i = 0; $i < $repeticiones; $i++) {
        $fechaActual = Carbon::parse($fecha)->addDays($i);
        Horario::create([
            'actividad_id' => $actividadId,
            'fecha' => $fechaActual,
            'hora' => $hora,
            'idioma' => $idioma,
            // Otros campos según sea necesario
        ]);
    }
}

private function crearHorariosSemanalmente($actividadId, $fecha, $hora, $idioma, $repeticiones)
{
    // Crea horarios semanales a partir de la fecha seleccionada
    for ($i = 0; $i < $repeticiones; $i++) {
        $fechaActual = Carbon::parse($fecha)->addWeeks($i);
        Horario::create([
            'actividad_id' => $actividadId,
            'fecha' => $fechaActual,
            'hora' => $hora,
            'idioma' => $idioma,
            // Otros campos según sea necesario
        ]);
    }
}

    public function getDias($actividadId)
    {
        $dias = Horario::where('actividad_id', $actividadId)
            ->pluck('dia_semana')
            ->unique()
            ->values()
            ->all();

        return response()->json($dias);
    }

    public function getActividadColorMap()
    {
        // Lógica para obtener colores de las actividades
        $actividades = Actividad::all();
        $actividadColorMap = [];

        foreach ($actividades as $actividad) {
            // Agrega más lógica si es necesario para asignar colores
            $actividadColorMap[$actividad->id] = '#' . substr(md5(rand()), 0, 6);
        }

        return $actividadColorMap;
    }

    public function destroy($id)
    {
        // Obtén el horario por su ID
        $horario = Horario::findOrFail($id);


        // Elimina el horario
        $horario->delete();

        return redirect()
            ->route('admin.horarios.index')
            ->with('success', 'Horario eliminado con éxito');
    }

    public function borrarHorarioConcreto($fecha, $hora)
    {
        // Encuentra y elimina el horario en la fecha y hora especificadas
        Horario::where('fecha', $fecha)
            ->where('hora', $hora)
            ->delete();

        return redirect()->route('admin.horarios.index')->with('success', 'Horario eliminado con éxito');
    }





    // public function borrarHorarioCompleto($idHorario)
    // {
    //     // Encuentra el horario por su ID y elimínalo
    //     $horario = Horario::find($idHorario);

    //     if (!$horario) {
    //         return redirect()->route('admin.horarios.index')->with('error', 'Horario no encontrado');
    //     }

    //     $horario->delete();

    //     return redirect()->route('admin.horarios.index')->with('success', 'Horario eliminado con éxito');
    // }

    //     public function borrarHorarioConcreto($idActividad, $diaSemana, $hora)
    // {
    //     // Encuentra y elimina todos los horarios para una actividad en un día y hora específicos
    //     Horario::where('actividad_id', $idActividad)
    //         ->where('dia_semana', $diaSemana)
    //         ->where('hora', $hora)
    //         ->delete();

    //     return redirect()->route('admin.horarios.index')->with('success', 'Horarios del día eliminados con éxito');
    // }
}
