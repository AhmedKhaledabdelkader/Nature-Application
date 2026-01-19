<?php

namespace App\Repositories\Eloquents;

use App\Models\ServiceV2;
use App\Repositories\Contracts\ServiceV2RepositoryInterface;

class ServiceV2Repository implements ServiceV2RepositoryInterface
{

    public function create(array $data)
    {
      
        return ServiceV2::create($data) ;
        
    }

    
    public function find(string $id){


     return ServiceV2::find($id) ;

    }



public function delete(string $id): bool
{
    $service = ServiceV2::find($id);
    
    if ($service) {
        return $service->delete();
    }
    
    return false;
}


    
}
