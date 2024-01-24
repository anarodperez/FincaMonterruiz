<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'apellido1' => 'required|string|min:3|max:255',
            'email' => 'required|email',
        ]);

        $user = $request->user();


        // Actualiza los campos del usuario con los datos validados del formulario
        $user->update([
            'nombre' => $request->input('nombre'),
            'apellido1' => $request->input('apellido1'),
            'apellido2' => $request->input('apellido2'),
            'telefono' => $request->input('telefono'),
            'email' => $request->input('email'),
        ]);

        // Verifica si el campo 'email' c`ambió y, en ese caso, restablece la verificación de email
        if ($user->wasChanged('email')) {
            $user->email_verified_at = null;
            $user->save();
        }

        // Redirige de vuelta a la página de edición de perfil con un mensaje de éxito
        return redirect()
            ->route('profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
