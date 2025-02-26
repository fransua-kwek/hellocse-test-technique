<?php

namespace Src\Domain\Image\Application;

use Illuminate\Support\Facades\Storage;
use Src\Domain\Image\Application\Contract\ImageServiceInterface;
use Src\Domain\Profile\Domain\ValueObjects\Image;

class ImageService implements ImageServiceInterface
{
     public function __construct(readonly private Storage $storage, readonly private Image $image)
     {
     }

     public function store (): string {
        // TODO
         return '';
     }
}
