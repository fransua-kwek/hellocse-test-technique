<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWT;

class JwtMiddleware
{
    public function __construct(private readonly JWT $jwt) {}

    public function handle($request, Closure $next)
    {
        try {
            $this->jwt->parseToken();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not valid'], 401);
        }

        return $next($request);
    }
}
