<?php

namespace Src\Domain\Image\Application\Contract;

use Illuminate\Http\UploadedFile;

interface ImageServiceInterface
{
     public function store (UploadedFile $file): string;
}
