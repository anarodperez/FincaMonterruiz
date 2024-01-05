<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Actividad;
use DateTime;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Reserva;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    public function index()
    {
        $horarios = Horario::with('actividad')->get();

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
                'fecha' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) use ($request) {
                        $fechaHora = Carbon::parse($value . ' ' . $request->hora);
                        \Log::debug('Fecha y hora de validación: ' . $fechaHora);

                        if ($fechaHora->isPast()) {
                            $fail('La fecha y hora del horario no pueden estar en el pasado.');
                        }
                    },

                ],
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Redirigir de vuelta con los errores de validación y los datos de entrada
            return redirect()->back()
                             ->withErrors($e->validator)
                             ->withInput();
        } catch (\Exception $e) {
            // Manejar otros tipos de excepciones
            \Log::error('Error al crear horario: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Hubo un problema al crear el horario')
                             ->withInput();
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

                                // Redirigir con un mensaje de éxito
                                return redirect()->route('admin.horarios.index')->with('success', 'Horario creado exitosamente.');
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

public function edit($id)
{
    $horario = Horario::findOrFail($id);
    $actividades = Actividad::where('activa', true)->get();
    // Determinar si el horario es recurrente (diario o semanal)
    $esRecurrente = in_array($horario->frecuencia, ['diario', 'semanal']);
    return view('admin.horarios.edit', compact('horario', 'actividades', 'esRecurrente'));
}

public function update(Request $request, $id)
{
    try {
        $request->validate([
            'fecha' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $fechaHora = Carbon::parse($value . ' ' . $request->hora);
                    if ($fechaHora->isPast()) {
                        $fail('La fecha y hora del horario no pueden estar en el pasado.');
                    }
                },
            ],
            'hora' => 'required',
            'idioma' => 'required',
        ]);

        $horario = Horario::findOrFail($id);
        $tipoEdicion = $request->input('tipo_edicion', 'instancia');

        if ($tipoEdicion == 'instancia') {
            // Actualiza solo esta instancia
            $horario->update($request->only(['fecha', 'hora', 'idioma']));
        } else {
            // Actualiza toda la serie
            $this->updateSerieRecurrente($horario, $request);
        }

        return redirect()->route('admin.horarios.index')->with('success', 'Horario actualizado exitosamente.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Redirigir de vuelta con los errores de validación y los datos de entrada
        return redirect()->back()
                         ->withErrors($e->validator)
                         ->withInput();
    } catch (\Exception $e) {
        // Manejar otros tipos de excepciones
        \Log::error('Error al actualizar el horario: ' . $e->getMessage());
        return redirect()->back()
                         ->with('error', 'Hubo un problema al actualizar el horario')
                         ->withInput();
    }
}


private function updateSerieRecurrente($horarioOriginal, $request)
{
    // Iniciar una transacción para asegurar la integridad de los datos
    DB::beginTransaction();

    try {
        $fechaNueva = $request->input('fecha');
        $horaNueva = $request->input('hora');
        $fechaHoraNueva = Carbon::parse($fechaNueva . ' ' . $horaNueva);

        if ($fechaHoraNueva->isPast()) {
            throw new \Exception('La fecha y hora del horario no pueden estar en el pasado.');
        }

        // Encuentra todos los horarios recurrentes que están asociados con la misma serie
        $horariosRecurrentes = Horario::where('actividad_id', $horarioOriginal->actividad_id)
                                      ->where('fecha', '>=', $horarioOriginal->fecha)
                                      ->get();

        foreach ($horariosRecurrentes as $horarioRecurrente) {
            // Asegúrate de no actualizar horarios pasados
            if ($horarioRecurrente->fecha > today() || ($horarioRecurrente->fecha == today() && $horarioRecurrente->hora > now())) {
                $horarioRecurrente->update([
                    'hora' => $horaNueva,
                    'idioma' => $request->input('idioma'),
                    'fecha' => $fechaNueva,
                ]);
            }
        }

        DB::commit();
        return true;
    } catch (\Exception $e) {
        // En caso de error, revertir la transacción
        DB::rollback();
        \Log::error('Error al actualizar la serie recurrente: ' . $e->getMessage());
        return back()->with('error', $e->getMessage());
    }
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

}
