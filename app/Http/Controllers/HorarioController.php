<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use  App\Models\Actividad;
use DateTime;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
{
    $horarios = Horario::all();

    $events = [];

    foreach ($horarios as $horario) {
        // Obtiene las fechas recurrentes utilizando el nuevo método
        $fechasRecurrentes = $horario->getFechasRecurrentes();

        foreach ($fechasRecurrentes as $fecha) {
            $events[] = [
                'title' => $horario->actividad->nombre,
                'start' => $fecha->format('Y-m-d H:i:s'),
                'allDay' => false,
                'idioma' => $horario->idioma,
                'color' => $horario->color, // Nuevo atributo de color
            ];
        }
    }

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
                'dia_semana' => 'required',
                'hora' => 'required|date_format:H:i',
                'idioma' => 'required|in:Español,Inglés,Francés',
                // Agrega otras reglas de validación según sea necesario
            ]);

            // Modifica el valor de la hora para asegurarte de incluir segundos
$horaConSegundos = $request->input('hora') . ':00';

            // Verifica si ya existe un horario con la misma actividad, día de la semana y hora
            $horarioExistente = Horario::where('actividad_id', $request->input('actividad'))
                ->where('dia_semana', $request->input('dia_semana'))
                ->where('hora', $horaConSegundos )
                ->first();

            if ($horarioExistente) {
                // Si ya existe, muestra un mensaje de error
                return redirect()->back()->withInput()->withErrors(['error' => 'Ya existe un horario con la misma actividad, día de la semana y hora.']);
            }


            // Crea un nuevo horario con los datos del formulario y guárdalo en la base de datos
            Horario::create([
                'actividad_id' => $request->input('actividad'),
                'dia_semana' =>  $request->input('dia_semana'),
                'hora' => $horaConSegundos ,
                'idioma' => $request->input('idioma'),
                // Agrega otros campos según sea necesario
            ]);

            // Redirecciona a la página de horarios o muestra un mensaje de éxito
            return redirect()->route('admin.horarios.index')->with('success', 'Horario creado exitosamente');
        } catch (\Exception $e) {
            // Imprime la excepción
            dd($e, $request->all(), $horaConSegundos );
        }
    }
    public function destroySelected(Request $request)
    {
        $request->validate([
            'horarios' => 'required|array',
            'horarios.*' => 'exists:horarios,id',
        ]);

        // Obtén los IDs de los horarios seleccionados desde el formulario
        $horariosIds = $request->input('horarios');

        // Elimina los horarios seleccionados
        Horario::whereIn('id', $horariosIds)->delete();

        return redirect()->route('admin.horarios.index')->with('success', 'Horarios seleccionados borrados exitosamente');
    }


public function selectDelete()
{
    // Obtén todos los horarios u otros datos necesarios y pasa a la vista
    $horarios = Horario::all(); // O utiliza cualquier lógica que necesites
    $actividades = Actividad::all();

    return view('admin.horarios.select-delete',[
        'horarios' => $horarios, 'actividades' => $actividades]);
}


public function getDias($actividadId)
{
    $dias = Horario::where('actividad_id', $actividadId)->pluck('dia_semana')->unique()->values()->all();

    return response()->json($dias);
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
