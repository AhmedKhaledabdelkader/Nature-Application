<?php

namespace App\Services;

use App\Repositories\Contracts\CityRepositoryInterface;
use App\Repositories\Eloquents\CityRepository;
use Illuminate\Support\Facades\App;

class CityService
{

    public $cityRepository;



    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }


    public function createCity(array $data) 
    {

    $locale = $data['locale'] ?? 'en';
    App::setLocale($locale);   
    $data['name'] = [
       $locale => $data['name'] ?? null,
    ];

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
        $city = $this->cityRepository->find($id);

        if (!$city) {
            return null;
        }

        $locale = $data['locale'] ?? 'en';
        App::setLocale($locale);

        if (isset($data['name'])) {
            
            $city->setLocalizedValue('name', $locale, $data['name']);
        }

        $city->save();

        return $city;
    }

     public function deleteCity(string $id): bool
    {
        return $this->cityRepository->delete($id);
    }






   
}
