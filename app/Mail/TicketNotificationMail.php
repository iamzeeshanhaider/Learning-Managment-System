<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $MailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($MailData)
    {
        $this->MailData = $MailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('LMS Guardians Training - New Support Ticket Created')
            ->view('emails.support.new_ticket');
    }
}
