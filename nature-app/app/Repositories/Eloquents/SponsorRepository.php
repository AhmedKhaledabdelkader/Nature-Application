<?php

namespace App\Repositories\Eloquents;

use App\Models\Sponsor;
use App\Repositories\Contracts\SponsorRepositoryInterface;

class SponsorRepository implements SponsorRepositoryInterface
{

    public function create(array $data)
    {
        return Sponsor::create($data);
    }

    public function find(string $id)
    {
        return Sponsor::find($id);
    }

     public function getAll($page,$size){


        return Sponsor::query()->paginate($size,['*'],'page',$page);

    }

    
    public function delete(string $id): bool
{
    $sponsor = Sponsor::find($id);
    
    if ($sponsor) {
        return $sponsor->delete();
    }
    
    return false;
}

    public function getAllSponsorsNames()
    {
        return Sponsor::all(['id', 'name']);
    }




 
}
