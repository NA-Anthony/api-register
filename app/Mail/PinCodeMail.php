<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PinCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pin;

    public function __construct($pin)
    {
        $this->pin = $pin;
    }

    public function build()
    {
        return $this->subject('Votre code PIN')
                    ->view('emails.pin_code')
                    ->with(['pin' => $this->pin]);
    }
}

