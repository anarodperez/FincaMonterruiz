<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Suscriptor;
use App\Mail\NewsletterMail;
use Illuminate\Support\Facades\Mail;

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
        $suscriptores = Suscriptor::all();

        foreach ($suscriptores as $suscriptor) {
            Mail::to($suscriptor->email)->send(new NewsletterMail("Tu mensaje de newsletter aquí"));
        }

        $this->info('Newsletter enviado con éxito.');
    }
}
