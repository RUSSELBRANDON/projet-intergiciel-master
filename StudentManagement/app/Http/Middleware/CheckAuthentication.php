<?php

namespace App\Http\Middleware;  

use Closure;
use Illuminate\Http\Request; 
use Illuminate\Http\JsonResponse;  
use Russel\Communicationservice\Contracts\ServiceCommunicatorInterface;

class CheckAuthentication
{
    protected $communicator;

    public function __construct(ServiceCommunicatorInterface $communicator)
    {
        $this->communicator = $communicator;
    }

    public function handle(Request $request, Closure $next, ...$roles)
{
    $token = $request->bearerToken();
    if (!$token) {
        return response()->json(['message' => 'Token missing'], 401);
    }

    try {
        \Log::debug('Attempting to verify token', ['token' => substr($token, 0, 10).'...']);

        $response = $this->communicator->call('AUTH-service', 'POST', 'api/verify-token', [
            'token' => $token,
            'required_roles' => $roles
        ]);

        \Log::debug('Auth service raw response', [
            'status' => $response->status(),
            'headers' => $response->headers(),
            'body' => $response->body()
        ]);

        if (!$response->ok()) {
            \Log::error('Auth service rejected token', ['status' => $response->status()]);
            return response()->json(['message' => 'Invalid token', 'auth_error' => $response->body()], 401);
        }

        $userData = $response->json();
        \Log::debug('Decoded user data', $userData);

        if (!isset($userData['user'])) {
            throw new \RuntimeException('Invalid auth service response format');
        }

        $request->merge(['user' => $userData['user']]);
        return $next($request);

    } catch (\Exception $e) {
        \Log::error('Auth service failure', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json([
            'message' => 'Authentication failed',
            'debug' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}
}