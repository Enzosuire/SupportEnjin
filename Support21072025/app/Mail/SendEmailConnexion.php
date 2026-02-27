<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class SendEmailConnexion extends Mailable
{
    /**
     * Create a new message instance.
     */
    public function __construct()
    {

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        \MailHelper::prepareMailable($this);

        $message = $this->subject(__('Découverte du Support ENJIN'))
                    ->view('emails/customer/presentation_support');

        return $message;
    }
}
