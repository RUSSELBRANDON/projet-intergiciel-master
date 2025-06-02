<?php

namespace App\Factories;

use App\Interfaces\NotificationInterface;
use App\Notifications\EmailNotification;
use App\Notifications\SmsNotification;

class NotificationFactory
{
    public function create(string $type): NotificationInterface
    {
        return match ($type) {
            'email' => new EmailNotification(),
            'sms' => new SmsNotification(),
            default => throw new \InvalidArgumentException("Type non supporté"),
        };
    }
}