<?php

namespace App\Mail;

use App\Models\Aplicacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class CreacionTurno extends Mailable
{
    use Queueable, SerializesModels;

    public $aplicacion;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Aplicacion $aplicacion)
    {
        $this->aplicacion = $aplicacion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Vacunassist - Vacuna aplicada')->view('mails.creacionTurno');
    }
}
