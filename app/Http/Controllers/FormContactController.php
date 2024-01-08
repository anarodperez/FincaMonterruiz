<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class FormContactController extends Controller
{

    public function index()
    {
        return view('pages.form-contact');
    }

    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'mensaje' => 'required'
        ]);

        Mail::to('anarodpe8@gmail.com')->send(new ContactMail($validatedData));

        return redirect()->back()->with('success', 'Mensaje enviado con éxito.');
    }
}
