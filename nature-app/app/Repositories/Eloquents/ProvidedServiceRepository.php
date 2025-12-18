<?php

namespace App\Repositories\Eloquents;

use App\Models\Provided_Service;
use App\Repositories\Contracts\ProvidedServiceRepositoryInterface;

class ProvidedServiceRepository implements ProvidedServiceRepositoryInterface
{

    public function create(array $data)
    {
        return Provided_Service::create($data);
    }



     public function find(string $id)
    {
        return Provided_Service::find($id);
    }

    public function all($page, $size)
    {
        return Provided_Service::query()->paginate($size, ['*'], 'page', $page);
    }

    

    public function delete(string $id): bool
    {
        $service = Provided_Service::find($id);
        if ($service) {
            return $service->delete();
        }
        return false;
    }
}






  

