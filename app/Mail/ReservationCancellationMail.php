<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reserva;

class ReservationCancellationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;
    protected $motivoCancelacion;

    /**
     * Create a new message instance.
     */
    public function __construct($reserva, $motivoCancelacion)
{
    $this->reserva = $reserva;
    $this->motivoCancelacion = $motivoCancelacion;
}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reserva cancelada',
        );
    }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    public function build()
    {
        return $this->view('emails.reservation_cancellation')
                    ->subject('Su reserva ha sido cancelada')
                    ->with([
                        'reserva' => $this->reserva,
                        'motivoCancelacion' => $this->motivoCancelacion, // Asegúrate de pasar esta variable a la vista
                    ]);
    }

}
