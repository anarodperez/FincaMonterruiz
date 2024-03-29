<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\AdminNotification;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|min:3',
            'apellido1' => 'required|string|min:5',
            'apellido2' => 'nullable|string|min:5',
            'email' => 'required|string|email|unique:users,email',
            'password' => ['required', 'confirmed'],
            'fecha_nacimiento' => 'required|date|before:-18 years',
            'telefono' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono' => $request->telefono,
        ]);

        // Actualizar contador de nuevos usuarios
        $notification = AdminNotification::first();
        if ($notification) {
            $notification->increment('nuevos_usuarios_count');
        } else {
            AdminNotification::create(['nuevos_usuarios_count' => 1]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
