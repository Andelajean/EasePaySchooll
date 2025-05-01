<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FinanceResultat extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $filePath;

    public function __construct($subject, $message, $filePath)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->filePath = $filePath;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('Concours.results')
                    ->attach($this->filePath, [
                        'as' => 'resultats_concours.pdf',
                        'mime' => 'application/pdf',
                    ])
                    ->with(['messageText' => $this->message]);
    }
}
