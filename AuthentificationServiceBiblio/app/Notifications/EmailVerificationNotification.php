<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class EmailVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $encryptedData = Crypt::encrypt([
            'email' => $notifiable->email,
            'code' => $this->code
        ]);

        $verificationUrl = route('verification.verify', [
            'data' => urlencode($encryptedData)
        ]);

        return (new MailMessage)
            ->subject('Vérification de votre adresse email')
            ->markdown('emails.verification', [
                'url' => $verificationUrl,
                'user' => $notifiable
            ]);
    }
}