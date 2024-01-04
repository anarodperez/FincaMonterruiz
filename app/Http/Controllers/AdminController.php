<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\User;
use App\Models\Reserva;
use App\Models\Valoracion;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $cantidadActividades = Actividad::count();
        $usuariosRegistrados = User::count();
        $now = Carbon::now();

        $reservasRecientes = Reserva::join('horarios', 'reservas.horario_id', '=', 'horarios.id')
            ->join('actividades', 'horarios.actividad_id', '=', 'actividades.id')
            ->where(function ($query) use ($now) {
                $query->where('horarios.fecha', '>', $now->toDateString())->orWhere(function ($query) use ($now) {
                    $query->where('horarios.fecha', '=', $now->toDateString())->where('horarios.hora', '>', $now->toTimeString());
                });
            })
            ->select('reservas.*', 'actividades.nombre as nombre_actividad', 'horarios.fecha as fecha_actividad', 'horarios.hora as hora_actividad')
            ->orderBy('horarios.fecha', 'desc')
            ->orderBy('horarios.hora', 'desc')
            ->take(4)
            ->get();

            $ultimasValoraciones = Valoracion::with(['user', 'actividad'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Pasa esa información a la vista
        return view('admin.index', [
            'cantidadActividades' => $cantidadActividades,
            'usuariosRegistrados' => $usuariosRegistrados,
            'reservasRecientes' => $reservasRecientes,
            'ultimasValoraciones' => $ultimasValoraciones,
        ]);
    }
}
