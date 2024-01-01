<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Horario;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'actividad', 'horario'])->get(); // Asegúrate de incluir todas las relaciones necesarias

        return view('admin.reservas.index', compact('reservas'));
    }


    public function create(Request $request, $horarioId)
    {
        // Método para mostrar el formulario de creación de una reserva

    }

    public function store(Request $request)
{
    // Validar los datos del formulario
    $validated = $request->validate([
        'num_adultos' => 'required|integer|min:0',
        'num_ninos' => 'required|integer|min:0',
        'observaciones' => 'nullable|string',
        'horario_id' => 'required|exists:horarios,id',
    ]);

    // Obtener el horario y la actividad relacionada
    $horario = Horario::with('actividad')->findOrFail($validated['horario_id']);
    $actividad = $horario->actividad;

    // Calcular el número total de personas para la reserva
    $numPersonas = $validated['num_adultos'] + $validated['num_ninos'];

    // Verificar si hay suficiente aforo disponible
    if ($actividad->aforo < $numPersonas) {
        return back()->withErrors(['error' => 'No hay suficiente aforo disponible para esta reserva.']);
    }

    // Crear la reserva
    $reserva = new Reserva();
    $reserva->num_adultos = $validated['num_adultos'];
    $reserva->num_ninos = $validated['num_ninos'];
    $reserva->horario_id = $validated['horario_id'];
    $reserva->user_id = Auth::id();
    $reserva->actividad_id = $actividad->id;
    $reserva->observaciones = $validated['observaciones'] ?? null;

    // Guardar la reserva
    $reserva->save();

    // Actualizar el aforo de la actividad
    $actividad->aforo -= $numPersonas;
    $actividad->save();

    return redirect()->route('dashboard')->with('success', 'Reserva realizada con éxito');
}


    public function show($horarioId)
    {
        $horario = Horario::findOrFail($horarioId);
        $actividad = Actividad::where('id', $horario->actividad_id)->firstOrFail();
        $usuario = auth()->user();

        return view('pages.reservar', compact('actividad', 'horario', 'usuario'));
    }




public function cancelar($id)
{
    $reserva = Reserva::findOrFail($id);
    $reserva->estado = 'cancelada'; // O el valor que corresponda
    $reserva->save();
    // Redirigir de vuelta con un mensaje
    return back()->with('success', 'Reserva cancelada correctamente.');
}




    public function edit(Reserva $reserva)
    {
        // Método para mostrar el formulario de edición de una reserva
    }

    public function update(Request $request, Reserva $reserva)
    {
        // Método para actualizar una reserva específica
    }

    public function destroy(Reserva $reserva)
    {
        // Método para borrar una reserva específica
    }
}
