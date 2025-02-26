<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Src\Domain\Auth\Application\AuthInterface;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private AuthInterface $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->auth->login([
                'email' => $request->getUserUsername(),
                'password' => $request->getUserPassword()
            ]);

            return $this->respondWithToken($token);
        } catch (ValidationException $validationException) {
            return response()->json($validationException->errors(), Response::HTTP_BAD_REQUEST);
        } catch (AuthenticationException) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED );
        }
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        try {
            $token = $this->auth->refresh();
        } catch (AuthenticationException $e) {
            return response()->json(['status' => $e->getMessage()], Response::HTTP_FORBIDDEN);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'accessToken' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 1,
        ]);
    }
}
