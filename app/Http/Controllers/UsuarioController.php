<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserva;
use Illuminate\Pagination\Paginator;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        // Resetear el contador de nuevos usuarios
        $notification = AdminNotification::first();
        if ($notification && $notification->nuevos_usuarios_count > 0) {
            $notification->update(['nuevos_usuarios_count' => 0]);
        }

        $terminoBusqueda = $request->input('termino_busqueda', '');

        // Inicia la consulta
        $query = User::query();

        // Aplica filtro si se recibe un término de búsqueda
        if ($request->has('termino_busqueda')) {
            $terminoBusqueda = $request->input('termino_busqueda');

            // Busca en varias columnas
            $query->where(function ($query) use ($terminoBusqueda) {
                $query
                    ->where('nombre', 'like', '%' . $terminoBusqueda . '%')
                    ->orWhere('apellido1', 'like', '%' . $terminoBusqueda . '%')
                    ->orWhere('email', 'like', '%' . $terminoBusqueda . '%')
                    ->orWhere('telefono', 'like', '%' . $terminoBusqueda . '%');
            });
        }

        // Ordenación
        if ($request->has('sort')) {
            $query->orderBy($request->input('sort'));
        }
        // Aplica paginación
        $usuarios = $query->paginate(5);

        // Asegura que los parámetros de búsqueda se mantengan durante la paginación
        if ($request->has('nombre')) {
            $usuarios->appends(['termino_busqueda' => $terminoBusqueda]);
        }

        // Obtener datos de reservas
        $datosReservas = Reserva::select(DB::raw("to_char(created_at, 'YYYY-MM-DD') as fecha"), DB::raw('count(*) as total'))
            ->groupBy('fecha')
            ->orderBy('fecha', 'asc')
            ->get();

        // Retorna la vista con los usuarios
        return view('admin.usuarios.index', [
            'usuarios' => $usuarios,
            'datosReservas' => $datosReservas,
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

    public function showDashboard(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now('UTC')->setTimezone('Europe/Madrid');

        $activePage = $request->query('activePage', 1);
        $pastPage = $request->query('pastPage', 1);

        // Obtener reservas activas
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
            ->paginate(3, ['*'], 'activePage', $activePage) // Especifica la página actual para activas
            ->appends(['pastPage' => $pastPage]); // Asegúrate de que los enlaces de paginación para activas incluyan el estado de la paginación para pasadas

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
            ->paginate(3, ['*'], 'pastPage', $pastPage) // Especifica la página actual para pasadas
            ->appends(['activePage' => $activePage]); // Asegúrate de que los enlaces de paginación para pasadas incluyan el estado de la paginación para activas

        // Obtener las valoraciones del usuario
        $valoracionesUsuario = $user
            ->valoraciones()
            ->with('actividad')
            ->paginate(3);

        return view('/dashboard', compact('reservasActivas', 'reservasPasadas', 'valoracionesUsuario'));
    }

    public function exportCsv()
    {
        $usuarios = User::all();
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=usuarios.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($usuarios) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nombre', 'Apellido', 'Email', 'Teléfono', 'Fecha de Nacimiento']);

            foreach ($usuarios as $usuario) {
                fputcsv($file, [$usuario->id, $usuario->nombre, $usuario->apellido1, $usuario->email, $usuario->telefono, $usuario->fecha_nacimiento]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
