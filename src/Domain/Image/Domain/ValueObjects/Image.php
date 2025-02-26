<?php

namespace Src\Domain\Image\Domain\ValueObjects;

use Exception;
use Illuminate\Http\UploadedFile;
use Src\Domain\Image\Application\ImageService;

final class Image
{
    /**
     * @throws Exception
     */
    public function __construct(
        public ?UploadedFile $binary_data,
        public ?string $filename,
    ) {
        if (! $this->binary_data && ! $this->filename) {
            throw new Exception('Image must be a non-empty string !');
        }

        if ($this->binary_data && ! $this->filename) {
            $this->filename = app()->make(ImageService::class)->store($this->binary_data);
        }
    }

    public function getImageUrl(): ?string
    {
        return asset('storage/'.$this->filename);
    }

    public function fileExists(): bool
    {
        return $this->filename && file_exists(storage_path('app/avatars/'.$this->filename));
    }

    public function __toString(): string
    {
        return $this->filename ?? '';
    }
}
