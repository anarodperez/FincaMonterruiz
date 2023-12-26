<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Actividad;
use App\Models\Horario;


class CatalogoController extends Controller
{

    public function index()
    {
        $horarios = Horario::with('actividad')->get(); // Obtiene todos los horarios con su actividad relacionada
        $actividades = Actividad::all();

        $events = $horarios->map(function ($horario) {
            return [
                'title' => $horario->actividad->nombre, // Asumiendo que la actividad tiene un campo 'nombre'
                'start' => $horario->fecha . 'T' . $horario->hora,
                'extendedProps' => [
                    'idioma' => $horario->idioma,
                    'horario_id' => $horario->id,
                    'frecuencia' => $horario->frecuencia, // Añade la frecuencia aquí

                ],
            ];
        });

        return view('pages.catalogo', compact('events', 'actividades'));
    }
}
