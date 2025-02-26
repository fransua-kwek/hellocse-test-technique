<?php

namespace Src\Domain\Image\Application;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Src\Domain\Image\Application\Contract\ImageServiceInterface;
use Src\Domain\Profile\Domain\ValueObjects\Image;

class ImageService implements ImageServiceInterface
{
    /**
     * @param UploadedFile $file
     * @return string
     * @throws Exception
     */
     public function store (UploadedFile $file): string
     {
         $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

         $finalFilename = $filename . '_' . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();

         if (! Storage::disk('public')->put($finalFilename, $file->getContent())) {
            throw new Exception('Error uploading file');
         }

         return $finalFilename;
     }
}
