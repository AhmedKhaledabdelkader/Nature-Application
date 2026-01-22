<?php

namespace App\Services;

use App\Repositories\Contracts\CountryRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;


use App\Repositories\Eloquents\CountryRepository;
use App\Traits\HandlesFileUpload;
use App\Traits\HandlesLocalization;
use App\Traits\LocalizesData;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class CountryService
{

    use HandlesFileUpload,HandlesLocalization,LocalizesData ;

    public $countryRepository;
    
    public function __construct(CountryRepositoryInterface $countryRepository,protected ImageConverterService $imageConverterService)
    {
        $this->countryRepository = $countryRepository;
    }



public function createCountry(array $data) 
{

    $locale = app()->getLocale();

    
    $this->localizeFields($data,['name'],$locale);
    
    $data["logo"]=$this->uploadFile($data['logo'] ?? null, 'countries', $this->imageConverterService);
    
    return $this->countryRepository->create($data);
}


public function getAllCountries()
{
  
    return $this->countryRepository->allCountries();
}














public function getCountryById(string $id)
{
    return $this->countryRepository->findCountry($id);
}



public function updateCountry(string $id, array $data) 
{
   
    $locale = app()->getLocale();

    $country = $this->countryRepository->findCountry($id);

    if (!$country) {
        return null;
    }

   $this->setLocalizedFields($country, $data, ['name'],$locale);

   $country->logo = $this->updateFile($data['logo'] ??null,$country->logo,'countries',$this->imageConverterService);

    $country->save();

    return $country;
}




public function deleteCountry(string $id)
{
    $country = $this->countryRepository->findCountry($id);
    
    if (!$country) {
        return false;
    }

    $this->deleteFile($country->logo);
    
   
    return $this->countryRepository->delete($id);
}




  
}
