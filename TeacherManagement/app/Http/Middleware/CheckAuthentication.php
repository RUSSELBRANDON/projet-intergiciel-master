<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
            return response()->json(['message' => 'No token provided'], 401);
        }
        
        try {
            $response = $this->communicator->call(
                service: 'AUTH-service',
                method: 'post',
                endpoint: '/api/verify-token',
                data: ['token' => $token],
                headers: ['Accept' => 'application/json']
            );        
                if ($response->ok()) {
                $user = $response->json()['user'];
                $request->merge(['current_user' => $user]);
                $request->session()->put('user', $user);
                $request->session()->save();
                return $next($request);
            } else {
                return response()->json(['message' => 'Error verifying token'], 500);
            }
        } catch (\Exception $e) {
            return  response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
