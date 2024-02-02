<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Suscriptor;
use App\Mail\NewsletterMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Newsletter;

class SendNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar newsletter a todos los suscriptores';

    /**
     * Execute the console command.
     */



     public function handle()
     {
        $newsletterActiva = Newsletter::where('selected', true)->where('id', '!=', 1)->first();

         if ($newsletterActiva) {
             $suscriptores = Suscriptor::all();

             foreach ($suscriptores as $suscriptor) {
                 Mail::to($suscriptor->email)->queue(new NewsletterMail($newsletterActiva, $suscriptor->email));
             }

             $this->info('Newsletter enviado con éxito a todos los suscriptores.');
         } else {
             $this->info('No hay una newsletter activa para enviar.');
         }
     }


}
