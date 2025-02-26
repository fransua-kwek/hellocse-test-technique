<?php

namespace Src\Domain\Profile\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Profile\Infrastructure\Repository\Contract\ProfileRepositoryInterface;
use Src\Domain\Profile\Infrastructure\Repository\ProfileRepository;

class ProfileServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ProfileRepositoryInterface::class,
            ProfileRepository::class
        );
    }
}
