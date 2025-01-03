<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommonMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailObj;

    public function __construct($mailObj)
    {
        $this->mailObj = $mailObj;
    }

    public function envelope()
    {
        $data = $this->mailObj;
        return new Envelope(
            subject: $data['mail_subject'],
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'emails.common_mail',
        );
    }

    public function attachments()
    {
        return [];
    }
}
