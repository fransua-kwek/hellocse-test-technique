<?php

namespace Src\Domain\Image\Application;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * @throws Exception
     */
    public function store(UploadedFile $file): string
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $finalFilename = $filename.'_'.Carbon::now()->timestamp.'.'.$file->getClientOriginalExtension();

        if (! Storage::disk('public')->put($finalFilename, $file->getContent())) {
            throw new Exception('Error uploading file');
        }

        return $finalFilename;
    }

    public function destroy(string $filename): bool
    {
        return Storage::disk('public')->delete($filename);
    }
}
