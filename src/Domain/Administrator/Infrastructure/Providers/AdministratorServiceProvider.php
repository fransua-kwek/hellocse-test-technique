<?php

namespace Src\Domain\Administrator\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Src\Domain\Administrator\Application\AdministratorRepositoryInterface;
use Src\Domain\Administrator\Infrastructure\Repository\AdministratorRepository;

class AdministratorServiceProvider extends ServiceProvider
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
            AdministratorRepositoryInterface::class,
            AdministratorRepository::class
        );
    }
}
