<?php

namespace App\Http\Controllers;
use App\Models\Actividad;
use App\Models\Valoracion;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home(Request $request)
    {
        $actividades = Actividad::all();
        $ultimasValoraciones = Valoracion::with('user')
        ->latest()
        ->take(3)
        ->get();

        return view('welcome', ['actividades' => $actividades, 'ultimasValoraciones' => $ultimasValoraciones]);
    }
}
