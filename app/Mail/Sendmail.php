<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Sendmail extends Mailable
{
    use Queueable, SerializesModels;

    public $dadosEmail;
    /**
     * Create a new message instance.
     */
    public function __construct($dadosEmail)
    {
        $this->dadosEmail = $dadosEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $mensagem_Subject = 'Você recebeu um novo Contato(' . date('d-m-Y') . ') através do '. config('app.name')  ;
        return new Envelope(
            subject: $mensagem_Subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.lead',
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
