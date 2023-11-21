<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use  App\Models\Actividad;
use DateTime;

use Illuminate\Http\Request;

class HorarioController extends Controller
{
    // public function index()
    // {
    //     $horarios = Horario::get();

    //     $events = [];

    //     foreach ($horarios as $horario) {
    //         $fecha = new DateTime($horario->fecha);
    //         $hora = new DateTime($horario->hora);
    //         $idioma = $horario->idioma;
    //         $plazas_disponibles = $horario->plazas_disponibles;

    //         $events[] = [
    //             'title' => $horario->actividad->nombre,
    //             'start' => $fecha->format('Y-m-d') . ' ' . $hora->format('H:i:s'),
    //             'allDay' => false,
    //             'idioma' => $idioma,
    //             'plazas_disponibles' => $plazas_disponibles
    //         ];
    //     }
    //     // dd($events);

    //     return view('admin.horarios.index', [
    //         'events' => $events,
    //     ]);
    // }

    public function index()
{
    $horarios = Horario::all(); // Obtén tus horarios de la base de datos
    $actividades = Actividad::with('horarios')->get();

    return view('admin.horarios.index', ['horarios' => $horarios],['actividades' => $actividades]);
}


    public function create()
    {
        $actividades = Actividad::all();
        return view('admin.horarios.create', compact('actividades'));
    }


    public function store(Request $request)
{
    $request->validate([
        // Agrega aquí las reglas de validación para los campos del formulario
    ]);

    // Crea una nueva instancia de Horario con los datos del formulario
    $horario = new Horario([
        'actividad_id' => $request->input('actividad_id'),
        'fecha' => $request->input('fecha'),
        'hora' => $request->input('hora'),
        'idioma' => $request->input('idioma'),
        'plazas_disponibles' => $request->input('plazas_disponibles'),
        // Agrega otros campos según sea necesario
    ]);

    // Guarda el nuevo horario en la base de datos
    $horario->save();

    // Redirecciona a la página de horarios o muestra un mensaje de éxito
    return redirect()->route('horarios.index')->with('success', 'Horario creado exitosamente');
}

}
