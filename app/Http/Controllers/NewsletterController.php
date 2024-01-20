<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function enviarNewsletter()
    {
        $suscriptores = Suscriptor::all();

        foreach ($suscriptores as $suscriptor) {
            Mail::to($suscriptor->email)->send(new NewsletterMail("Tu mensaje de newsletter aquí"));
        }

        return back()->with('success', 'Newsletter enviado con éxito a todos los suscriptores.');
    }


}
