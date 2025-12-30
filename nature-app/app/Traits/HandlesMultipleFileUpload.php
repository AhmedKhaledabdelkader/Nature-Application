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

    $id=1 ;
    foreach ($files as $file) {
        $storedPath = $imageConverterService->convertAndStore($file, $folder);

        $paths[] = [
            "id" => $id++,                   //uniqid(),           // unique identifier for frontend tracking
            "url" => $storedPath,       // path returned from converter
        ];
    }

    return $paths;
}

/**
 * Update multiple files (delete old files and upload new ones)
 */
public function updateMultipleFiles(
    ?array $newFiles,
    ?array $oldFiles,
    string $folder,
    ImageConverterService $imageConverterService,
    string $disk = 'private'
): array {
    // Delete old files if they exist
    if (!empty($oldFiles) && is_array($oldFiles)) {
        foreach ($oldFiles as $oldFileObj) {
            if (!empty($oldFileObj['url']) && Storage::disk($disk)->exists($oldFileObj['url'])) {
                Storage::disk($disk)->delete($oldFileObj['url']);
            }
        }
    }

    // Upload new files and return them as array of objects
    return $this->uploadMultipleFiles(
        $newFiles,
        $folder,
        $imageConverterService,
        $disk
    );
}

/**
 * Delete multiple files
 */
public function deleteMultipleFiles(
    ?array $files,
    string $disk = 'private'
): bool {
    if (empty($files) || !is_array($files)) {
        return false;
    }

    foreach ($files as $fileObj) {
        if (!empty($fileObj['url']) && Storage::disk($disk)->exists($fileObj['url'])) {
            Storage::disk($disk)->delete($fileObj['url']);
        }
    }

    return true;
}

    
    
}
