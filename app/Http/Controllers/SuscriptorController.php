<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Suscriptor;
use App\Mail\NewsletterMail;

use Illuminate\Support\Facades\Mail;

class SuscriptorController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:suscriptores,email',
        ]);

        Suscriptor::create($validatedData);

        // Enviar el correo de bienvenida
        Mail::to($validatedData['email'])->send(new NewsletterMail($validatedData['email']));

        return back()->with('success', '¡Gracias por suscribirte!');
    }

    public function cancelarSuscripcion(Request $request)
    {
        $email = $request->query('email');

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Redirecciona o muestra un mensaje si el email no es válido
            return redirect('/')->with('error', 'Dirección de correo electrónico no válida.');
        }

        $suscriptor = Suscriptor::where('email', $email)->first();

        if ($suscriptor) {
            // Aquí puedes marcar al suscriptor como 'cancelado' o eliminarlo
            $suscriptor->delete(); // O cualquier lógica para 'cancelar' la suscripción

            return view('emails.cancelada', ['email' => $email]);

        } else {
            return redirect('/')->with('error', 'Suscriptor no encontrado.');
        }
    }

}
