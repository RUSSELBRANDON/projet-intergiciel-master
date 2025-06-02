<?php

namespace App\Services;

use App\Factories\NotificationFactory;
use App\Interfaces\NotificationInterface;

class NotificationService
{
    public function __construct(
        private NotificationFactory $factory
    ) {}

    public function send(string $type, array $data): void
    {
        $this->factory
            ->create($type)
            ->send($data);
    }
}