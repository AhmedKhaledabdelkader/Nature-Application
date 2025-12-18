<?php

namespace App\Services;

use App\Repositories\Contracts\CountryRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;


use App\Repositories\Eloquents\CountryRepository;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class CountryService
{

    public $countryRepository;
    
    public function __construct(CountryRepositoryInterface $countryRepository,protected ImageConverterService $imageConverterService)
    {
        $this->countryRepository = $countryRepository;
    }



public function createCountry(array $data) 
{
    $locale = $data['locale'] ?? 'en';
    App::setLocale($locale);
    
    $data['name'] = [
       $locale => $data['name'] ?? null,
    ];
    
    if (!empty($data['logo'])) {

        $data['logo'] = $this->imageConverterService->convertAndStore($data['logo'], 'countries');
    }
    
    return $this->countryRepository->create($data);
}


public function getAllCountries(array $data)
{
    $size = $data['size'] ?? 10;
    $page = $data['page'] ?? 1;

    return $this->countryRepository->all($page, $size);
}


















public function getCountryById(string $id)
{
    return $this->countryRepository->find($id);
}


public function updateCountry(string $id, array $data) 
{
    $locale = $data['locale'] ?? 'en';
    App::setLocale($locale);

    $country = $this->countryRepository->find($id);

    if (!$country) {
        return null;
    }

    // Update localized name
    if (isset($data['name'])) {
        $country->setLocalizedValue('name', $locale, $data['name']);
    }

    // Update logo
    if (!empty($data['logo'])) {

        // Delete old logo
        if ($country->logo && Storage::disk('private')->exists($country->logo)) {
            Storage::disk('private')->delete($country->logo);
        }

        // Store new logo
        $newLogoPath = $this->imageConverterService->convertAndStore($data['logo'], 'countries');

        // 🔥 THIS WAS MISSING
        $country->logo = $newLogoPath;
    }

    $country->save();

    return $country;
}




public function deleteCountry(string $id)
{
    $country = $this->countryRepository->find($id);
    
    if (!$country) {
        return false;
    }
    
    // Delete logo if exists
    if ($country->logo && Storage::disk('private')->exists($country->logo)) {
        Storage::disk('private')->delete($country->logo);
    }
    
    return $this->countryRepository->delete($id);
}




  
}
