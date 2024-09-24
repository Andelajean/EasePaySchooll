<?php

namespace App\Mail;

use App\Models\Ecole;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EcoleMail extends Mailable
{
    use Queueable, SerializesModels;
    public $ecole;
    public function __construct(Ecole $ecole)
    {
        $this->ecole=$ecole;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject:"Cette Message est Destiné à .$this->ecole['nom_ecole",
        );
    }

    /**
     * Get the message content definition.
     */
      public function mailuser(){
        return $this->view('Ecole.email-inscription')
                    ->subject('Merci d\'avoir fait confiance à EasePaySchol')
                    ->with('Ecole', $this->ecole);
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
