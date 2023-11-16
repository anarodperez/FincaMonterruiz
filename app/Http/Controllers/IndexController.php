<?php

namespace App\Http\Controllers;
use App\Models\Actividad; // Importa el modelo Actividad
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home()
    {
        $actividades = Actividad::all();
        return view('welcome', ['actividades' => $actividades]);
    }
}
