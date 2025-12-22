<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;

class PortfolioService
{


   public function addPortfolioFile(array $data)
{
    if (empty($data['portfolio_file'])) {
        return null;
    }

    $disk = 'private';
    $folder = 'portfolios';

    // 1️⃣ Delete any existing file (ONLY ONE FILE ALLOWED)
    $existingFiles = Storage::disk($disk)->files($folder);

    foreach ($existingFiles as $file) {
        Storage::disk($disk)->delete($file);
    }

    // 2️⃣ Store the new file
    $filePath = $data['portfolio_file']->storeAs(
        $folder, 'full-awards-portfolio.' . $data['portfolio_file']->getClientOriginalExtension(),$disk);

    return $filePath;
}



public function getPortfolioFile()
{
    $files = Storage::disk('private')->files('portfolios');

    if (empty($files)) {
        return null;
    }

    // Since there is ONLY ONE FILE
    return $files[0];
}


public function deletePortfolioFile()
{
    $files = Storage::disk('private')->files('portfolios');

    if (empty($files)) {
        return false;
    }

    foreach ($files as $file) {
        Storage::disk('private')->delete($file);
    }

    return true;
}


public function updatePortfolioFile($file)
{
    // Delete old file if exists
    $files = Storage::disk('private')->files('portfolios');

    foreach ($files as $oldFile) {
        Storage::disk('private')->delete($oldFile);
    }

    // Store new file
    $filePath = $file->storeAs(
        'portfolios',
        'full-awards-portfolio.' . $file->getClientOriginalExtension(),
        'private'
    );

    return $filePath;
}





    
}
