<?php

namespace App\Http\Controllers;

use App\Models\User; // Importa el modelo Usuario

use Illuminate\Http\Request;

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
}
