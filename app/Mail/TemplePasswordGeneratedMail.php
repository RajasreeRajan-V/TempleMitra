<?php

namespace App\Mail;

use App\Models\TemplesRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TemplePasswordGeneratedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $temple;
    public $plainPassword;

    /**
     * Create a new message instance.
     */
    public function __construct(
        TemplesRegistration $temple,
        string $plainPassword
    ) {
        $this->temple = $temple;
        $this->plainPassword = $plainPassword;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Temple Registration - Login Credentials')
            ->view('emails.temple_password');
    }
}