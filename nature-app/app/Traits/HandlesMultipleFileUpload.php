<?php

namespace App\Traits;


use App\Services\ImageConverterService;
use Illuminate\Support\Facades\Storage;

trait HandlesMultipleFileUpload
{

public function uploadMultipleFiles(
    ?array $files,
    string $folder,
    ImageConverterService $imageConverterService,
    string $disk = 'private'
): array {

    if (empty($files) || !is_array($files)) {
        return [];
    }

    $paths = [];

    foreach ($files as $file) {

        if ($file instanceof \Illuminate\Http\UploadedFile) {

            $storedPath = $imageConverterService->convertAndStore($file, $folder);

            $paths[] = $storedPath;
        }
    }

    return $paths;
}



public function updateMultipleFiles(
    ?array $incomingFiles,
    ?array $oldFiles,
    string $folder,
    ImageConverterService $imageConverterService,
    string $disk = 'private'
):array {

    // If no input → keep old images
    if (empty($incomingFiles)) {
        return $oldFiles ?? [];
    }

    $existingPaths = [];
    $newUploads = [];

    // Separate strings and files
    foreach ($incomingFiles as $item) {

        if (is_string($item)) {
            $existingPaths[] = $item;
        }

        if ($item instanceof \Illuminate\Http\UploadedFile) {
            $newUploads[] = $item;
        }
    }

    // Old paths from DB
    $oldPaths = $oldFiles ?? [];

    // Find removed images
    $filesToDelete = array_diff($oldPaths, $existingPaths);

   

    // Delete removed
    foreach ($filesToDelete as $path) {

        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }

    
    }

    // Upload new images
    $uploadedPaths = $this->uploadMultipleFiles(
        $newUploads,
        $folder,
        $imageConverterService,
        $disk
    );

    // Merge kept + new
    return array_values(array_merge(
        $existingPaths,
        $uploadedPaths
    ));
}



/**
 * Delete multiple files
 */

 
public function deleteMultipleFiles(
    ?array $paths,
    string $disk = 'private'
): bool {

    if (empty($paths) || !is_array($paths)) {
        return false;
    }

    foreach ($paths as $path) {

        if (is_string($path) && Storage::disk($disk)->exists($path)) {

            Storage::disk($disk)->delete($path);
        }
    }

    return true;
}

    
    
}
