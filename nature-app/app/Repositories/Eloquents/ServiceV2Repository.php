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


public function getAll($page, $size)
{
    return ServiceV2::query()
        ->select([
            'id',
            'name',
            'tagline',
            'status',
            'created_at',
            'updated_at'
        ])
        ->paginate($size, ['*'], 'page', $page);
}



public function search(string $key, string $value, int $page, int $size)
{
    $allowedKeys = ['name','tagline'];

    if (!in_array($key, $allowedKeys)) {
        abort(400, 'Invalid search key');
    }

    $locale = app()->getLocale(); // ar or en

    return ServiceV2::query()
        ->whereRaw(
            "JSON_UNQUOTE(JSON_EXTRACT($key, '$.$locale')) LIKE ?",
            ["{$value}%"]
        )
        ->latest()
        ->paginate($size, ['*'], 'page', $page);
    
}

public function getAllServicesNames()
{
    return ServiceV2::query()
        ->select(['id', 'name'])
        ->where('status', true)
        ->get();
}


    
}
