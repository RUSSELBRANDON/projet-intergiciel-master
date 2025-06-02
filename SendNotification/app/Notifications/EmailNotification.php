<?php

namespace App\Notifications;

use App\Interfaces\NotificationInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomEmail;

class EmailNotification implements NotificationInterface
{
    public function send(array $data): void
    {
        Mail::to($data['to'])->send(
            new CustomEmail($data['subject'], $data['body'])
        );
    }
}