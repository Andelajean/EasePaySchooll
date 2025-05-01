<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FinanceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidates;
    public $pdf;

    public function __construct($candidates, $pdf)
    {
        $this->candidates = $candidates;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Votre affectation de salle d\'examen du concours Management & Finance ')
                    ->view('Concours.Admin.partagemail',[
                        'candidates' => $this->candidates
                    ])
                    ->attachData($this->pdf->output(), 'Concours.Admin.affectation', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
