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
        $usuarios = User::query();

        if ($request->has('nombre')) {
            $nombre = $request->input('nombre');
            $usuarios->where('nombre', 'like', '%' . $nombre . '%');
        }

        $usuarios = $usuarios->get();

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
        $today = Carbon::today();

        // Obtener reservas activas (fechas futuras)
        $reservasActivas = $user
            ->reservas()
            ->join('horarios', 'reservas.horario_id', '=', 'horarios.id')
            ->join('actividades', 'horarios.actividad_id', '=', 'actividades.id')
            ->where('horarios.fecha', '>=', $today)
            ->select('reservas.*', 'actividades.nombre as nombre_actividad', 'horarios.fecha as fecha_actividad')
            ->get();

        // Obtener reservas pasadas (fechas anteriores)
        $reservasPasadas = $user
            ->reservas()
            ->join('horarios', 'reservas.horario_id', '=', 'horarios.id')
            ->where('horarios.fecha', '<', $today)
            ->get();
        return view('/dashboard', compact('reservasActivas', 'reservasPasadas'));
    }
    public function cargarReservas()
    {
        $user = auth()->user(); // Obtener el usuario autenticado

        // Obtener reservas activas y pasadas
        $reservasActivas = Reserva::where('user_id', $user->id)
                                  ->whereDate('fecha', '>=', now())
                                  ->get();

        $reservasPasadas = Reserva::where('user_id', $user->id)
                                  ->whereDate('fecha', '<', now())
                                  ->get();

        // Devuelve la vista parcial de reservas con los datos
        return view('dashboard.reservas', compact('reservasActivas', 'reservasPasadas'));
    }
    public function cargarValoraciones()
    {
        $user = auth()->user();
        $valoraciones = Valoracion::where('user_id', $user->id)->get();

        return view('dashboard.valoraciones', compact('valoraciones'));
    }

    public function cargarPerfil()
    {
        $user = auth()->user(); // o User::find(auth()->id());

        // Aquí, puedes pasar directamente el usuario a la vista
        // Si necesitas más datos específicos, puedes obtenerlos y pasarlos a la vista
        return view('dashboard.perfil', compact('user'));
    }
}
