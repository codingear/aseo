<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $username = 'webmaker';
        $password = 'Meg@blaster007@7251';

        // Check if Authorization header is present
        if (!$request->hasHeader('Authorization')) {
            return $this->unauthorizedResponse();
        }

        $authHeader = $request->header('Authorization');
        
        // Check if it's Basic Auth
        if (!str_starts_with($authHeader, 'Basic ')) {
            return $this->unauthorizedResponse();
        }

        // Decode the credentials
        $credentials = base64_decode(substr($authHeader, 6));
        [$providedUsername, $providedPassword] = explode(':', $credentials, 2);

        // Verify credentials
        if ($providedUsername !== $username || $providedPassword !== $password) {
            return $this->unauthorizedResponse();
        }

        return $next($request);
    }

    /**
     * Return unauthorized response
     */
    private function unauthorizedResponse()
    {
        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'Valid Basic Authentication credentials are required'
        ], 401, [
            'WWW-Authenticate' => 'Basic realm="API"'
        ]);
    }
}
