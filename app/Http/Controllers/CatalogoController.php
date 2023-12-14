<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Actividad;


class CatalogoController extends Controller
{
    public function index()
    {

        {
            $actividades = Actividad::all();
            return view('catalogo', [
                'actividades' => $actividades,
            ]);
        }
    }
}
