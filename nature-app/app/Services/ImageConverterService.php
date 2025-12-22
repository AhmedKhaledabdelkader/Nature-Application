<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class ImageConverterService
{
    public function convertAndStore($image, string $directory, int $maxWidth = 1920, int $maxHeight = 1080): string
    {
        $manager = new ImageManager(new Driver());

        $img = $manager->read($image);

        // Resize if image is larger than max dimensions
        if ($img->width() > $maxWidth || $img->height() > $maxHeight) {
            $img->scale(
                width: $maxWidth,
                height: $maxHeight
            );
        }

        $filename = uniqid() . '.webp';
        $path = $directory . '/' . $filename;

        $webp = $img->toWebp(75);

        Storage::disk('private')->put($path, $webp);

        return $path;
    }
}