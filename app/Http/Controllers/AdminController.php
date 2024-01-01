<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\User;
use App\Models\Reserva;

class AdminController extends Controller
{
    public function index(){
    $cantidadActividades = Actividad::count();
    $usuariosRegistrados = User::count();
     $reservasRecientes = Reserva::latest()->take(5)->get();

    // Pasa esa información a la vista
    return view('admin.index', [
        'actividadesDisponibles' => $cantidadActividades,
        'usuariosRegistrados' => $usuariosRegistrados,
        'reservasRecientes' => $reservasRecientes
    ]);
}
}
