<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Valoracion;
use App\Models\Actividad;
use App\Models\AdminNotification;

class ValoracionController extends Controller
{
    public function index()
    {
        // Resetear el contador de nuevas valoraciones

        $notification = AdminNotification::first();

        if ($notification && $notification->nuevos_valoraciones_count > 0) {
            $notification->update(['nuevos_valoraciones_count' => 0]);
        }

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
            'comentario' => 'nullable|string|max:500',
        ]);

        Valoracion::create([
            'user_id' => auth()->id(),
            'actividad_id' => $request->actividad_id,
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);

        // Actualizar contador de nuevas valoraciones
        $notification = AdminNotification::first();
        if ($notification) {
            $notification->increment('nuevos_valoraciones_count');
        } else {
            AdminNotification::create(['nuevos_valoraciones_count' => 1]);
        }
        return redirect()
            ->route('dashboard')
            ->with('success', 'Valoración enviada con éxito.');
    }

    // Método para mostrar el formulario de edición de la valoración
    public function edit($id)
    {}

    // Método para actualizar la valoración
    public function update(Request $request, $id)
    {
        $valoracion = Valoracion::findOrFail($id);

        $request->validate([
            'puntuacion' => 'integer|min:1|max:5|nullable',
            'comentario' => 'nullable|string|max:500',
        ]);

        $datosActualizados = [];
        if ($request->filled('puntuacion')) {
            $datosActualizados['puntuacion'] = $request->puntuacion;
        }
        if ($request->filled('comentario')) {
            $datosActualizados['comentario'] = $request->comentario;
        }

        if (!empty($datosActualizados)) {
            $valoracion->update($datosActualizados);
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Valoración actualizada con éxito.');
    }

    public function destroy($id)
    {
        $valoracion = Valoracion::findOrFail($id);
        $valoracion->delete();

        return redirect()
            ->back()
            ->with('success', 'Valoración borrada con éxito.');
    }
}
