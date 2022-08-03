<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccesoUsuarios extends Mailable
{
    use Queueable, SerializesModels;

    public $info;
    public $pass;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $password)
    {
        $this->info = $data;
        $this->pass = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Datos usuario SIPEFAB')->view('correos.nuevoUsuario');
    }
}
