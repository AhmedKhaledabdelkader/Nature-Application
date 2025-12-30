<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    // 🔹 Get original filename without extension
    $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

    // 🔹 Clean name + unique id
    $filename = Str::slug($originalName) . '_' . uniqid() . '.webp';

    $path = $directory . '/' . $filename;

    $webp = $img->toWebp(75);

    Storage::disk('private')->put($path, $webp);

    return $path;
      
}
}