<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Suscriptor;
use App\Mail\NewsletterMail;
use App\Models\Newsletter;

use Illuminate\Support\Facades\Mail;

class SuscriptorController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:suscriptores,email',
        ]);

        // Crear el nuevo suscriptor
        Suscriptor::create($validatedData);

        // Enviar la newsletter de bienvenida
        $newsletterBienvenida = Newsletter::find(1); // la ID 1 es siempre la de bienvenida
        if ($newsletterBienvenida) {
            Mail::to($validatedData['email'])->send(new NewsletterMail($newsletterBienvenida, $validatedData['email']));
        }

        return back()->with('success', '¡Gracias por suscribirte!');
    }


    public function cancelarSuscripcion(Request $request)
    {
        $email = $request->query('email');

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect('/')->with('error', 'Dirección de correo electrónico no válida.');
        }

        $suscriptor = Suscriptor::where('email', $email)->first();

        if ($suscriptor) {
            // eliminamos el suscriptor
            $suscriptor->delete();

            return view('emails.cancelada', ['email' => $email]);

        } else {
            return redirect('/')->with('error', 'Suscriptor no encontrado.');
        }
    }

}
