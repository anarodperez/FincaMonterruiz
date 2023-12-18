<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Actividad;
use DateTime;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        // Obtén los horarios con la relación 'actividad' cargada
        $horarios = Horario::all();

        $events = collect([]);

        foreach ($horarios as $horario) {
            foreach ($horario->getFechasRecurrentes() as $fecha) {
                $events->push([
                    'title' => $horario->actividad->nombre,
                    'start' => $fecha->format('Y-m-d H:i:s'),
                    'allDay' => false,
                    'idioma' => $horario->idioma,
                    'color' => $horario->color,
                    'horario_id' => $horario->id
                ]);
            }
        }

        // Convierte la colección a un array para evitar problemas al renderizar en la vista
        $events = $events
            ->unique('start')
            ->values()
            ->all();
        return view('admin.horarios.index', [
            'events' => $events,
        ]);



    }

    public function create()
    {
        $actividades = Actividad::all();
        return view('admin.horarios.create', compact('actividades'));
    }

    public function store(Request $request)
{
    try {
        $request->validate([
            'actividad' => 'required|exists:actividades,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'idioma' => 'required|in:Español,Inglés,Francés',
            'frecuencia' => 'required|in:unico,diario,semanal', // Ajusta las opciones según tus necesidades
            'repeticiones' => 'required_if:frecuencia,diario,semanal|numeric|min:1',
        ]);

        $actividadId = $request->input('actividad');
        $fecha = $request->input('fecha');
        $hora = $request->input('hora');
        $idioma = $request->input('idioma');
        $frecuencia = $request->input('frecuencia');
        $repeticiones = $request->input('repeticiones');

        // Crea un horario único
        if ($frecuencia === 'unico') {
            $this->crearHorarioUnico($actividadId, $fecha, $hora, $idioma);
        }
        // Crea horarios diarios
        elseif ($frecuencia === 'diario') {
            $this->crearHorariosDiarios($actividadId, $fecha, $hora, $idioma, $repeticiones);
        }
        // Crea horarios semanales
        elseif ($frecuencia === 'semanal') {
            $this->crearHorariosSemanalmente($actividadId, $fecha, $hora, $idioma, $repeticiones);
        }

        // Redirecciona a la página de horarios o muestra un mensaje de éxito
        return redirect()
            ->route('admin.horarios.index')
            ->with('success', 'Horario(s) creado(s) exitosamente');
    } catch (\Exception $e) {
        // Maneja la excepción
        dd($e->getMessage(), $request->all());
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
