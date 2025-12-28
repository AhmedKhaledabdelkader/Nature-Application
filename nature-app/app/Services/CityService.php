<?php

namespace App\Services;

use App\Repositories\Contracts\CityRepositoryInterface;
use App\Repositories\Eloquents\CityRepository;
use App\Traits\HandlesLocalization;
use App\Traits\LocalizesData;
use Illuminate\Support\Facades\App;

class CityService
{

    use HandlesLocalization,LocalizesData ;


    public $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }


    public function createCity(array $data) 
    {

     $locale = app()->getLocale();
    
    $this->localizeFields($data,['name'],$locale);

    return $this->cityRepository->create($data);


    }



    public function getCitiesByCountry(string $countryId, array $data)
    {
        $size = $data['size'] ?? 10;
        $page = $data['page'] ?? 1;

        return $this->cityRepository->allByCountry($countryId, $page, $size);
    }


     public function getCityById(string $id)
    {
        return $this->cityRepository->find($id);
    }


    public function updateCity(string $id, array $data)
    {

    $locale = app()->getLocale();


    $city = $this->cityRepository->find($id);

        if (!$city) {
            return null;
        }
        
    $this->setLocalizedFields($city, $data, ['name'],$locale);

    $city->save();

    return $city;

    
    }

     public function deleteCity(string $id): bool
    {
        return $this->cityRepository->delete($id);
    }






   
}
