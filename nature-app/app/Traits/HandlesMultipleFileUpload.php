<?php

namespace App\Traits;


use App\Services\ImageConverterService;
use Illuminate\Support\Facades\Storage;

trait HandlesMultipleFileUpload
{

    public function uploadMultipleFiles(
        ?array $files,
        string $folder,
        ImageConverterService $imageConverterService
    ): array {
        if (empty($files) || !is_array($files)) {
            return [];
        }

        $paths = [];

        foreach ($files as $file) {
            $paths[] = $imageConverterService->convertAndStore($file, $folder);
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
        // If no new files, keep old ones
        if (empty($newFiles) || !is_array($newFiles)) {
            return $oldFiles ?? [];
        }

        // Delete old files
        if (!empty($oldFiles) && is_array($oldFiles)) {
            foreach ($oldFiles as $oldFile) {
                if ($oldFile && Storage::disk($disk)->exists($oldFile)) {
                    Storage::disk($disk)->delete($oldFile);
                }
            }
        }

        // Upload new files
        return $this->uploadMultipleFiles(
            $newFiles,
            $folder,
            $imageConverterService
        );
    }

  
    public function deleteMultipleFiles(
        ?array $files,
        string $disk = 'private'
    ): bool {
        if (empty($files) || !is_array($files)) {
            return false;
        }

        foreach ($files as $file) {
            if ($file && Storage::disk($disk)->exists($file)) {
                Storage::disk($disk)->delete($file);
            }
        }

        return true;
    }
    
}
