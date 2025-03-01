<?php

use Src\Domain\Administrator\Infrastructure\Providers\AdministratorServiceProvider;
use Src\Domain\Auth\Infrastructure\Providers\AuthServiceProvider;
use Src\Domain\Profile\Infrastructure\Providers\ProfileServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    AdministratorServiceProvider::class,
    AuthServiceProvider::class,
    ProfileServiceProvider::class,
];
