<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Actividad;
use DateTime;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Reserva;


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
        // Obtener solo actividades activas
        $actividades = Actividad::where('activa', true)->get();
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
                    break;
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
    // Verificar si ya existe un horario con las mismas características
    $existeHorario = Horario::where('actividad_id', $actividadId)
                             ->where('fecha', $fecha)
                             ->where('hora', $hora)
                             ->where('idioma', $idioma)
                             ->exists();

                             if (!$existeHorario) {
                                $horario = new Horario();
                                $horario->actividad_id = $actividadId;
                                $horario->fecha = $fecha;
                                $horario->hora = $hora;
                                $horario->idioma = $idioma;
                                $horario->frecuencia = 'unico';
                                $horario->save();
                            } else {
                                // Redirigir con un mensaje de error
                                return redirect()->back()->with('error', 'El horario que intenta crear ya existe.');
                            }

}

private function crearHorariosRecurrentes($actividadId, $fechaInicio, $hora, $idioma, $frecuencia, $repeticiones)
{
    $fecha = Carbon::parse($fechaInicio);
    for ($i = 0; $i < $repeticiones; $i++) {
        // Verificar si ya existe un horario con las mismas características
        $existeHorario = Horario::where('actividad_id', $actividadId)
                                 ->where('fecha', $fecha->toDateString())
                                 ->where('hora', $hora)
                                 ->where('idioma', $idioma)
                                 ->exists();

        if (!$existeHorario) {
            $horario = new Horario();
            $horario->actividad_id = $actividadId;
            $horario->fecha = $fecha->toDateString();
            $horario->hora = $hora;
            $horario->idioma = $idioma;
            $horario->frecuencia = $frecuencia;
            $horario->save();
        } else {
            // Manejar el caso de horario duplicado, por ejemplo, lanzar una excepción o devolver un mensaje de error
        }

        $frecuencia === 'diario' ? $fecha->addDay() : $fecha->addWeek();
    }
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

    public function destroy($horarioId)
    {
        // Comprobar si hay reservas para este horario
        $reservas = Reserva::where('horario_id', $horarioId)->count();

        if ($reservas > 0) {
            // No permitir borrar el horario y enviar un mensaje de error
            return redirect()->route('admin.horarios.index')->with('error', 'No se puede borrar el horario ya que existen reservas asociadas.');
        }

        // Si no hay reservas, proceder con el borrado
        $horario = Horario::findOrFail($horarioId);
        $horario->delete();

        return redirect()->route('admin.horarios.index')->with('success', 'Horario eliminado con éxito');
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
