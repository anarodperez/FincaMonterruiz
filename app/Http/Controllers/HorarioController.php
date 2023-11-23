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




        // Crea un nuevo horario con los datos del formulario y guárdalo en la base de datos
        Horario::create([
            'actividad_id' => $request->input('actividad'),
            'dia_semana' =>  $request->input('dia_semana'),
            'hora' => '13:00:00',
            'idioma' => $request->input('idioma'),
            // Agrega otros campos según sea necesario
        ]);
        // Redirecciona a la página de horarios o muestra un mensaje de éxito
        return redirect()->route('admin.horarios.index')->with('success', 'Horario creado exitosamente');
    } catch (\Exception $e) {
        // Imprime la excepción
        dd($e,$request->all(),$request->input('hora'));
    }
    }



}
