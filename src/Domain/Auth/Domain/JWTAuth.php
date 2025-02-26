<?php

namespace Src\Domain\Auth\Domain;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Log;
use Src\Domain\Administrator\Application\AdministratorRepositoryInterface;
use Src\Domain\Auth\Application\AuthInterface;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as TymonJWTAuth;

class JWTAuth implements AuthInterface
{
    public function __construct(private readonly AdministratorRepositoryInterface $administratorRepository)
    {}

    public function login(array $credentials): string
    {
        $administrator = $this->administratorRepository->getByEmail($credentials['email']);

        if (!$administrator || !auth()->attempt($credentials)) {
            throw new AuthenticationException();
        }

        return TymonJWTAuth::fromUser($administrator);
    }

    public function logout(): void
    {
        auth()->logout();
    }

    public function refresh(): string
    {
        try {
            return TymonJWTAuth::parseToken()->refresh();
        } catch (JWTException $e) {
            Log::error($e->getMessage());
            throw new AuthenticationException($e->getMessage());
        }
    }
}
