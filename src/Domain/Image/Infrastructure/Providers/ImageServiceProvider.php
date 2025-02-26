<?php

namespace Src\Domain\Image\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Image\Application\Contract\ImageServiceInterface;
use Src\Domain\Image\Application\ImageService;

class ImageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ImageServiceInterface::class,
            ImageService::class
        );
    }
}
