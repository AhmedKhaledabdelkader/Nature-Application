<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;



class ImageConverterService
{
    public function convertAndStore($image, string $directory): string
    {
        $manager = new ImageManager(new Driver());

        $img = $manager->read($image);

        $filename = uniqid() . '.webp';
        $path = $directory . '/' . $filename;

        $webp = $img->toWebp(90);

        Storage::disk('private')->put($path, $webp);

        return $path;
    }
}





