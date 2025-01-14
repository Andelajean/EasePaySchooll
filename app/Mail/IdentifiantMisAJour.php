<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IdentifiantMisAJour extends Mailable
{
    use Queueable, SerializesModels;

    public $ecole;
    public $nouvelIdentifiant;

    /**
     * Create a new message instance.
     */
    public function __construct($ecole, $nouvelIdentifiant)
    {
        $this->ecole = $ecole;
        $this->nouvelIdentifiant = $nouvelIdentifiant;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Mise à jour de votre identifiant')
                    ->view('Ecole.email_profil');
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
