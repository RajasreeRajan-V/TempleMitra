<?php

namespace App\Mail;

use App\Models\TemplesRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TempleOneMonthNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public TemplesRegistration $temple;
    public bool $isAdmin;

    public function __construct(
        TemplesRegistration $temple,
        bool $isAdmin = false
    ) {
        $this->temple = $temple;
        $this->isAdmin = $isAdmin;
    }

    public function build()
    {
        if ($this->isAdmin) {
            return $this
                ->subject('Temple Registration - One Month Completed')
                ->view('emails.temple_one_month_notification');
        }

        return $this
            ->subject('TempleMitra - One Month Registration Reminder')
            ->view('emails.temple_one_month_notification');
    }
}