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

    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('user')) {
            return $next($request);
        }
        
        $token = $request->bearerToken();
        if (!$token) {
            return new JsonResponse(['message' => 'No token provided'], 401);
        }
        
        try {
            $response = $this->communicator->call('auth-service', 'POST', 'api/verify-token', ['token' => $token]);
            if ($response->ok()) {
                $user = $response->json()['user'];
                $request->session()->put('user', $user);
                return $next($request);
            } else {
                return new JsonResponse(['message' => 'Error verifying token'], 500);
            }
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'Error verifying token'], 500);
        }
    }
}