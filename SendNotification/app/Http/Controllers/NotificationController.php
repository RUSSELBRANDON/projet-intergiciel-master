<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendNotificationRequest;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    public function send(SendNotificationRequest $request, NotificationService $service)
    {
        $validated = $request->validated();
        
        $service->send(
            $validated['type'],
            $validated['data']
        );

        return response()->json(['message' => 'Notification traitée']);
    }
}