<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ValidarUsuarioMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->validado) {
            // Agrega un mensaje de error a la sesión
            Session::flash('error', 'Tu cuenta no está validada. Por favor, verifica tu cuenta.');
        }

        return $next($request);
    }
}
