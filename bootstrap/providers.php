<?php

use Src\Domain\Administrator\Infrastructure\Providers\AdministratorServiceProvider;
use Src\Domain\Auth\Infrastructure\Providers\AuthServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    AdministratorServiceProvider::class,
    AuthServiceProvider::class
];
