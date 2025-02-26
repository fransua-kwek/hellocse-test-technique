<?php

namespace Src\Domain\Auth\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Src\Domain\Auth\Application\AuthInterface;
use Src\Domain\Auth\Domain\JWTAuth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

    }

    public function register(): void
    {
        $this->app->bind(
            AuthInterface::class,
            JWTAuth::class
        );
    }
}
