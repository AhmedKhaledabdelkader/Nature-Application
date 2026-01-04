<?php

namespace App\Services;

use App\Repositories\Contracts\ProvidedServiceRepositoryInterface;
use App\Traits\HandlesLocalization;
use App\Traits\HandlesUnlocalized;
use App\Traits\LocalizesData;
use Illuminate\Support\Facades\App;

class ProvidedServiceService
{


     use HandlesLocalization,LocalizesData,HandlesUnlocalized ;

    public $providedRepository;


    public function __construct(ProvidedServiceRepositoryInterface $providedRepository)
    {
        $this->providedRepository=$providedRepository ;
    }


     public function createService(array $data) 
    {


     $locale = app()->getLocale();

    $this->localizeFields($data,['title','sub_title'],$locale);


     return $this->providedRepository->create($data);

    }


 public function getAllServices(array $data)
    {
        $size = $data['size'] ?? 10;
        $page = $data['page'] ?? 1;

        return $this->providedRepository->all($page, $size);
    }

    // Get by ID
    public function getServiceById(string $id)
    {
        return $this->providedRepository->find($id);
    }




public function getAllServicesNames()
    {
        return $this->providedRepository->getAllServicesNames();
    }


    // Update
    public function updateService(string $id, array $data)
    {

         $locale = app()->getLocale();


        $service = $this->providedRepository->find($id);

        if (!$service) {
            return null;
        }


        $this->setLocalizedFields($service, $data, ['title','sub_title'],$locale);

       $this->setUnlocalizedFields($service, $data, ['color']);

        $service->save();

        return $service;
    }

    
    public function deleteService(string $id): bool
    {
        return $this->providedRepository->delete($id);
    }
}







