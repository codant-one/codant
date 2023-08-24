<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class solicitud extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = 'Nueva solicitud de servicio Codant';
    public $datosTexto;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datosTexto)
    {
        $this->datosTexto = $datosTexto; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->view('mail.solicitudes')
            ->with('datosTexto', $this->datosTexto);
    }
}
