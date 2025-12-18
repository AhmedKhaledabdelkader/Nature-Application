<?php

namespace App\Services;

use App\Repositories\Contracts\SponsorRepositoryInterface;
use App\Repositories\Eloquents\SponsorRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class SponsorService
{
    public $sponsorRepository;

    public function __construct(SponsorRepositoryInterface $sponsorRepository,protected ImageConverterService $imageConverterService)
    {
        $this->sponsorRepository = $sponsorRepository;
    }


    public function createSponsor(array $data) 
    
    {

        
    $locale = $data['locale'] ?? 'en';
    App::setLocale($locale);   
    $data['name'] = [
       $locale => $data['name'] ?? null,
    ];

      if (!empty($data['logo'])) {

        $data['logo'] = $this->imageConverterService->convertAndStore($data['logo'], 'sponsors');
    }

        return $this->sponsorRepository->create($data);

        
    }


    public function updateSponsor(string $id, array $data)
{
    $sponsor = $this->sponsorRepository->find($id);

    if (!$sponsor) {
        return null;
    }

    // 🌍 Locale handling
    $locale = $data['locale'] ?? 'en';
    App::setLocale($locale);

    // 📝 Update localized name
    if (isset($data['name'])) {
        $sponsor->setLocalizedValue('name', $locale, $data['name']);
    }

    // 🖼️ Update logo (delete old → save new)
    if (!empty($data['logo'])) {

        // delete old logo if exists
        if ($sponsor->logo && Storage::disk('private')->exists($sponsor->logo)) {
            Storage::disk('private')->delete($sponsor->logo);
        }

        // store new logo
        $newLogo = $this->imageConverterService
            ->convertAndStore($data['logo'], 'sponsors');

        $sponsor->logo = $newLogo;
    }

    // 💾 Save changes
    $sponsor->save();

    return $sponsor;
}

   
    








    
}
