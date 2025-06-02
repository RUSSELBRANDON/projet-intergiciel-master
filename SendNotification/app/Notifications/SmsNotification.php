<?php

namespace App\Notifications;

use App\Interfaces\NotificationInterface;
use Illuminate\Support\Facades\Log;

class SmsNotification implements NotificationInterface
{
    public function send(array $data): void
    {
        Log::channel('sms')->info("SMS simulé", [
            'to' => $data['to'],
            'message' => $data['message']
        ]);
    }
}