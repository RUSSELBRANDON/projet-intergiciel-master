<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VerifyServiceSecret
{
    public function handle(Request $request, Closure $next)
    {
        $secret = $request->header('Authorization');
        if (!$secret || !str_starts_with($secret, 'Bearer ')) {
            return new JsonResponse(['message' => 'Invalid service secret'], 401);
        }
        
        $secret = substr($secret, 7);
        $ownService = config('app.name');
        $expectedSecret = config("communicationservice.services.$ownService.secret");
        
        if ($secret !== $expectedSecret) {
            return new JsonResponse(['message' => 'Invalid service secret'], 401);
        }
        
        return $next($request);
    }
}