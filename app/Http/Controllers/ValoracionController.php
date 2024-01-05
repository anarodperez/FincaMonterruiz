<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Valoracion;
use App\Models\Actividad;

class ValoracionController extends Controller
{

    public function index()
    {
        $valoraciones = Valoracion::with(['user', 'actividad'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('admin.valoraciones.index', compact('valoraciones'));
    }

    // Método para mostrar el formulario de valoración
    public function create($idActividad)
    {
        $actividad = Actividad::findOrFail($idActividad);
        return view('pages.valorar', compact('actividad'));
    }

    // Método para almacenar la valoración
    public function store(Request $request)
    {
        $request->validate([
            'actividad_id' => 'required|exists:actividades,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);

        Valoracion::create([
            'user_id' => auth()->id(),
            'actividad_id' => $request->actividad_id,
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);

        return redirect()->route('dashboard')->with('success', 'Valoración enviada con éxito.');

    }

    public function destroy($id)
    {
        $valoracion = Valoracion::findOrFail($id);

        $valoracion->delete();

        return redirect()->back()->with('success', 'Valoración borrada con éxito.');
    }
}
