<?php

namespace Src\Domain\Image\Domain\ValueObjects;

use Illuminate\Contracts\Container\BindingResolutionException;
use Src\Domain\Image\Application\Contract\ImageServiceInterface;
use Src\Domain\Image\Application\ImageService;

final class Image
{
    /**
     * @param string|null $binary_data
     * @param string|null $filename
     */
    public function __construct(
        public ?string $binary_data,
        public ?string $filename
    ) {
        if ($this->binary_data && !$this->filename) {
            /**
             * @var ImageService $imageService
             */
            $imageService =  app(ImageServiceInterface::class);
            $this->filename = $imageService->store($this->binary_data);
        }
    }

    public function getImageUrl(): ?string
    {
        return asset('storage/' . $this->filename);
    }

    public function fileExists(): bool
    {
        return $this->filename && file_exists(storage_path('app/avatars/' . $this->filename));
    }

    public function __toString(): string
    {
        return $this->filename ?? '';
    }
}
