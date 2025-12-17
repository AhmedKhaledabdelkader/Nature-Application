<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageConverterService
{

    public function convertAndStore(
        $image,
        string $directory,
        int $quality = 90
    ): string {
        $filename = uniqid() . '.webp';
        $path = $directory . '/' . $filename;

        $imageResource = imagecreatefromstring(
            file_get_contents($image->getRealPath())
        );

        if ($imageResource === false) {
            throw new \Exception('Failed to create image resource');
        }

        $tempPath = sys_get_temp_dir() . '/' . $filename;

        imagewebp($imageResource, $tempPath, $quality);

        Storage::disk('private')->put(
            $path,
            file_get_contents($tempPath)
        );

        unlink($tempPath);

        return $path;
    }
}





