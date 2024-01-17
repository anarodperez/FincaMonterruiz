<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ValidarUsuarioMiddleware
{
    public function handle($request, Closure $next)
    {
        // Verifica si el usuario está autenticado y validado
        if (Auth::check() && !Auth::user()->validado) {
            Auth::logout(); // Cierra la sesión del usuario

            // Opcionalmente, invalida la sesión actual para prevenir su uso
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('error', 'Tu cuenta no está validada.');
        }
        return $next($request);
    }
}
