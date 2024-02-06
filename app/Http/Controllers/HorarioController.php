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
            // Verificar si la actividad está presente
            if (!is_null($horario->actividad)) {
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
                        'horario_id' => $horario->id,
                        'frecuencia' => $horario->frecuencia,
                        'aforoDisponible' => $aforoDisponible,
                        'estado' => $horario->oculto,
                    ],
                ];
            }
            return null;
        });

        // Filtrar los eventos nulos
        $events = $events->filter();

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

            $resultado = true; // Asumir éxito inicialmente
            switch ($frecuencia) {
                case 'unico':
                    $resultado = $this->crearHorario($actividadId, $fecha, $hora, $idioma);
                    break;
                case 'diario':
                case 'semanal':
                    $resultado = $this->crearHorariosRecurrentes($actividadId, $fecha, $hora, $idioma, $frecuencia, $repeticiones);
                    break;
            }

            if ($resultado) {
                return redirect()
                    ->route('admin.horarios.index')
                    ->with('success', 'Horario(s) creado(s) exitosamente.');
            } else {
                return redirect()
                ->route('admin.horarios.index')
                    ->with('error', 'Uno o más de los horarios que intentas crear ya existen.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // Manejar otros tipos de excepciones
            \Log::error('Error al crear horario: ' . $e->getMessage());
            return redirect()
                ->back()
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

            return true;
        } else {
            return false;
        }
    }

    private function crearHorariosRecurrentes($actividadId, $fechaInicio, $hora, $idioma, $frecuencia, $repeticiones)
{
    $fecha = Carbon::parse($fechaInicio);
    $conflictoEncontrado = false;

    for ($i = 0; $i < $repeticiones; $i++) {
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
            $conflictoEncontrado = true;
        }

        $frecuencia === 'diario' ? $fecha->addDay() : $fecha->addWeek();
    }

    return !$conflictoEncontrado; // Devuelve true si no se encontró ningún conflicto
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
                    'sometimes',
                    'date',
                    function ($attribute, $value, $fail) use ($request) {
                        $fechaHora = Carbon::parse($value . ' ' . $request->hora);
                        if ($fechaHora->isPast()) {
                            $fail('La fecha y hora del horario no pueden estar en el pasado.');
                        }
                    },
                ],
                'hora' => 'sometimes',
                'idioma' => 'sometimes',
            ]);


        $horario = Horario::findOrFail($id);

        // Asegúrate de que no se modifique un horario con reservas asociadas
        if ($horario->reservas()->count() > 0) {
            return redirect()->back()->with('error', 'No se puede modificar un horario que tiene reservas asociadas.')->withInput();
        }

        $tipoEdicion = $request->input('tipo_edicion', 'instancia');

        // Verificar si el nuevo horario coincide con otro existente (que no sea el mismo)
        $existeHorario = Horario::where('id', '!=', $id)
            ->where('actividad_id', $horario->actividad_id)
            ->where('fecha', $request->input('fecha'))
            ->where('hora', $request->input('hora'))
            ->where('idioma', $request->input('idioma'))
            ->exists();

        if ($existeHorario) {
            return redirect()->back()->with('error', 'El horario que intentas actualizar coincide con otro existente.')->withInput();
        }

        if ($tipoEdicion == 'instancia') {
            // Actualiza solo esta instancia
            $horario->update($request->only(['fecha', 'hora', 'idioma']));
        } else {
            $resultado = $this->updateSerieRecurrente($horario, $request);
            if (!$resultado) {
                return redirect()->back()->with('error', 'No se pudo actualizar la serie debido a un conflicto de horarios.')->withInput();
            }
        }

        return redirect()->route('admin.horarios.index')->with('success', 'Horario actualizado exitosamente.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        \Log::error('Error al actualizar el horario: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Hubo un problema al actualizar el horario')->withInput();
    }
}


private function updateSerieRecurrente($horarioOriginal, $request)
{
    DB::beginTransaction();

    try {
        $horariosRecurrentes = Horario::where('actividad_id', $horarioOriginal->actividad_id)
            ->where('fecha', '>=', $horarioOriginal->fecha)
            ->get();

        foreach ($horariosRecurrentes as $horarioRecurrente) {
            // Verificar si el horario actualizado coincide con otro existente que no sea parte de la serie recurrente
            $existeHorario = Horario::where('id', '!=', $horarioRecurrente->id)
                ->where('actividad_id', $horarioOriginal->actividad_id)
                ->where('fecha', $request->input('fecha'))
                ->where('hora', $request->input('hora'))
                ->where('idioma', $request->input('idioma'))
                ->exists();

            if ($existeHorario) {
                DB::rollback();
                return false; // Indicar que hubo un conflicto y no se completó la actualización
            }

            // Asegurarte de no actualizar horarios pasados
            if ($horarioRecurrente->fecha > today() || ($horarioRecurrente->fecha == today() && $horarioRecurrente->hora > now()->format('H:i'))) {
                $horarioRecurrente->update([
                    'fecha' => $request->input('fecha'),
                    'hora' => $request->input('hora'),
                    'idioma' => $request->input('idioma'),
                ]);
            }
        }

        DB::commit();
        return true;
    } catch (\Exception $e) {
        DB::rollback();
        \Log::error('Error al actualizar la serie recurrente: ' . $e->getMessage());
        return false;
    }
}

    public function destroy($horarioId)
    {
        // Obtener el horario
        $horario = Horario::findOrFail($horarioId);

        // Verificar si el horario no tiene reservas asociadas y si no está cancelado
        if ($horario->reservas->isEmpty() && $horario->estado !== 'cancelado') {
            $horario->delete();

            return redirect()
                ->route('admin.horarios.index')
                ->with('success', 'Horario eliminado con éxito');
        }
        return redirect()
            ->route('admin.horarios.index')
            ->with('error', 'No se puede borrar el horario ya que tiene reservas asociadas.');
    }

    public function ocultar(Request $request)
    {
        $horarioId = $request->input('horario_id');

        // Buscar el horario por su ID
        $horario = Horario::findOrFail($horarioId);
        $horario->oculto = !$horario->oculto;

        $horario->save();
        return redirect()
            ->back()
            ->with('success', 'Estado del horario cambiado con éxito.');
    }
}
