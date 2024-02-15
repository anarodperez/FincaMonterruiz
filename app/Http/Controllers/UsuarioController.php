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
        $datosReservas = Reserva::select(DB::raw("to_char(created_at, 'YYYY-MM-DD') as fecha"), DB::raw('count(*) as total'))->groupBy('fecha')->orderBy('fecha', 'asc')->get();

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

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario validado/invalidado correctamente');
    }

    public function showDashboard(Request $request)
    {
        $user = Auth::user(); //obtener usuario autenticado
        $now = Carbon::now('UTC')->setTimezone('Europe/Madrid'); //obtiene la fecha y hora actuales

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
            ->paginate(3, ['*'], 'activePage', $activePage)
            ->appends(['pastPage' => $pastPage]);

        // Para reservas pasadas
        $reservasPasadas = $user
            ->reservas()
            ->join('horarios', 'reservas.horario_id', '=', 'horarios.id')
            ->join('actividades', 'horarios.actividad_id', '=', 'actividades.id')
            ->where(function ($query) use ($now) {
                $query->where('horarios.fecha', '<', $now->toDateString())->orWhere(function ($query) use ($now) {
                    $query->where('horarios.fecha', '=', $now->toDateString())->where('horarios.hora', '<', $now->toTimeString());
                });
            })
            ->where('reservas.user_id', '=', $user->id)
            ->select('reservas.id as reserva_id', 'reservas.*', 'actividades.nombre as nombre_actividad', 'horarios.fecha as fecha_actividad', 'horarios.hora as hora_actividad') // Añadir esta línea
            ->paginate(3, ['*'], 'pastPage', $pastPage)
            ->appends(['activePage' => $activePage]);

        // Obtener las valoraciones del usuario
        $valoracionesUsuario = $user->valoraciones()->with('actividad')->paginate(3);

        return view('/dashboard', compact('reservasActivas', 'reservasPasadas', 'valoracionesUsuario'));
    }

    // método para exportar datos de usuarios a un archivo CSV
    public function exportCsv()
    {
        // Obtener todos los registros de usuarios de la base de datos
        $usuarios = User::all();

        // Preparar los encabezados HTTP para la respuesta, asegurando que el navegador trate la respuesta como un archivo CSV para descargar
        $headers = [
            'Content-type' => 'text/csv', // Indicar que el contenido es un archivo CSV
            'Content-Disposition' => 'attachment; filename=usuarios.csv', // Forzar la descarga del archivo con el nombre 'usuarios.csv'
            'Pragma' => 'no-cache', // Indicar que no se debe almacenar en caché la respuesta
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0', // Directivas adicionales de control de caché
            'Expires' => '0', // Indicar que la respuesta expira inmediatamente
        ];

        // Definir una función anónima para escribir los datos de los usuarios en un archivo CSV
        $callback = function () use ($usuarios) {
            // Abrir un "archivo" en la salida estándar PHP para escribir los datos del CSV
            $file = fopen('php://output', 'w');

            // Escribir la fila de encabezados en el CSV
            fputcsv($file, ['ID', 'Nombre', 'Apellido', 'Email', 'Teléfono', 'Fecha de Nacimiento']);

            // Iterar sobre cada usuario y escribir sus datos en el archivo CSV
            foreach ($usuarios as $usuario) {
                fputcsv($file, [$usuario->id, $usuario->nombre, $usuario->apellido1, $usuario->email, $usuario->telefono, $usuario->fecha_nacimiento]);
            }

            // Cerrar el "archivo" después de escribir todos los datos
            fclose($file);
        };

        // Enviar la respuesta al navegador, utilizando la función anónima para generar el contenido del CSV en tiempo real
        return Response::stream($callback, 200, $headers);
    }
}
