<?php

namespace App\Repositories\Eloquents;

use App\Models\Country;
use App\Repositories\Contracts\CountryRepositoryInterface;

class CountryRepository implements CountryRepositoryInterface
{

    public function create(array $data)
    {
        return Country::create($data);
    }


    public function find(string $id)
{
    return Country::with('projects.city')->find($id);
}


    public function all($page,$size)
    {
 
         return Country::query()->paginate($size,['*'],'page',$page);
    }

    public function update(string $id, array $data)
    {
        $country = Country::find($id);
        if ($country) {
            $country->update($data);
            return $country;
        }
        return null;
    }


    public function delete(string $id): bool
{
    $country = Country::find($id);
    
    if ($country) {
        return $country->delete();
    }
    
    return false;
}




}
