<?php

namespace App\Http\Controllers;
use App\Models\Actividad;
use App\Models\Valoracion;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home(Request $request)
    {
        // Filtra las actividades para obtener solo aquellas que están activas
        $actividades = Actividad::where('activa', true)->get();
        $ultimasValoraciones = Valoracion::with('user')
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', ['actividades' => $actividades, 'ultimasValoraciones' => $ultimasValoraciones]);
    }
}
