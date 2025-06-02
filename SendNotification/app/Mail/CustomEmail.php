<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;

    /**
     * Crée une nouvelle instance du message.
     */
    public function __construct(string $subject, string $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Construit le message.
     */
    public function build()
    {
        return $this
            ->subject($this->subject) 
            ->view('emails.custom') 
            ->with(['body' => $this->body]); 
    }
}