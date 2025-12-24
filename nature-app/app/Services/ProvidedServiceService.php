<?php

namespace App;

use App\Repositories\Contracts\ProvidedServiceRepositoryInterface;
use Illuminate\Support\Facades\App;

class ProvidedServiceService
{
    public $providedRepository ;


    public function __construct(ProvidedServiceRepositoryInterface $providedRepository)
    {
        $this->providedRepository=$providedRepository ;
    }


     public function createService(array $data) 
    {

    $locale = $data['locale'] ?? 'en';
    App::setLocale($locale);   

    $data['title'] = [
       $locale => $data['title'] ?? null,
    ];


     $data['sub_title'] = [
       $locale => $data['sub_title'] ?? null,
    ];

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

    // Update
    public function updateService(string $id, array $data)
    {
        $service = $this->providedRepository->find($id);

        if (!$service) {
            return null;
        }

        $locale = $data['locale'] ?? 'en';
        App::setLocale($locale);

        if (isset($data['title'])) {
            $service->setLocalizedValue('title', $locale, $data['title']);
        }

        if (isset($data['sub_title'])) {
            $service->setLocalizedValue('sub_title', $locale, $data['sub_title']);
        }

        if (isset($data['color'])) {
            
            $service->color=$data["color"];
        }

        $service->save();

        return $service;
    }

    
    public function deleteService(string $id): bool
    {
        return $this->providedRepository->delete($id);
    }
}







