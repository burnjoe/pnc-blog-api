<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ForgetMail extends Mailable
{
    use Queueable, SerializesModels;
    //add a token as public

    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct($token)
    {
        $this->data = $token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    { 
        // message for email
        return new Envelope(
            from: new Address('derlajulius48@gmail.com', 'PnCBlog!'),
            replyTo: [
                new Address('derlajulius48@gmail.com', 'PnCBlog!'),
            ],
            subject: 'Reset Password Link',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            //sent to forget page 
            //view :
            view: 'mail.forget',
            with: ['data'=> $this->data],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
