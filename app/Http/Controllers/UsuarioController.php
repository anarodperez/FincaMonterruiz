<?php

namespace App\Http\Controllers;

use App\Models\User; // Importa el modelo Usuario

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserva;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        // Inicia la consulta
        $query = User::query();

        // Aplica filtro si se recibe un nombre
        if ($request->has('nombre')) {
            $nombre = $request->input('nombre');
            $query->where('nombre', 'like', '%' . $nombre . '%');
        }

        // Aplica paginación
        $usuarios = $query->paginate(5);

        // Asegura que los parámetros de búsqueda se mantengan durante la paginación
        if ($request->has('nombre')) {
            $usuarios->appends(['nombre' => $nombre]);
        }

        // Retorna la vista con los usuarios
        return view('admin.usuarios.index', [
            'usuarios' => $usuarios,
        ]);
    }

    public function validar(User $usuario)
    {
        $usuario->validado = !$usuario->validado;
        $usuario->save();

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario validado/invalidado correctamente');
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term');

        $results = User::where('nombre', 'like', '%' . $term . '%')
            ->orWhere('apellidos', 'like', '%' . $term . '%')
            ->orWhere('email', 'like', '%' . $term . '%')
            ->get();

        return response()->json($results);
    }

    public function showDashboard()
    {
        $user = Auth::user();
        $now = Carbon::now('UTC')->setTimezone('Europe/Madrid');

        // Obtener reservas activas (fechas y horas futuras)
        $reservasActivas = $user
            ->reservas()
            ->join('horarios', 'reservas.horario_id', '=', 'horarios.id')
            ->join('actividades', 'horarios.actividad_id', '=', 'actividades.id')
            ->where(function ($query) use ($now) {
                $query->where('horarios.fecha', '>', $now->toDateString())->orWhere(function ($query) use ($now) {
                    $query->where('horarios.fecha', '=', $now->toDateString())->where('horarios.hora', '>', $now->toTimeString());
                });
            })
            ->select('reservas.*', 'actividades.nombre as nombre_actividad', 'horarios.fecha as fecha_actividad', 'horarios.hora as hora_actividad')
            ->get();

        // Para reservas pasadas
        $reservasPasadas = $user
            ->reservas()
            ->join('horarios', 'reservas.horario_id', '=', 'horarios.id')
            ->join('users', 'reservas.user_id', '=', 'users.id')
            ->where(function ($query) use ($now) {
                $query->where('horarios.fecha', '<', $now->toDateString())->orWhere(function ($query) use ($now) {
                    $query->where('horarios.fecha', '=', $now->toDateString())->where('horarios.hora', '<', $now->toTimeString());
                });
            })
            ->where('reservas.user_id', '=', $user->id)
            ->get();

        // Obtener las valoraciones del usuario
        $valoracionesUsuario = $user
            ->valoraciones()
            ->with('actividad') // Suponiendo que quieres incluir datos de la actividad valorada
            ->get();

        return view('/dashboard', compact('reservasActivas', 'reservasPasadas', 'valoracionesUsuario'));
    }
}
