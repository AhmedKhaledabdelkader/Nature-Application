<?php

namespace App\Repositories\Eloquents;

use App\Models\City;
use App\Repositories\Contracts\CityRepositoryInterface;

class CityRepository implements CityRepositoryInterface
{
    public function create(array $data)
    {
        return City::create($data);
    }

    public function find(string $id)
    {
        return City::find($id);
    }

    public function allByCountry(string $countryId, int $page, int $size)
    {
        return City::where('country_id', $countryId)
            ->paginate($size, ['*'], 'page', $page);
    }

    public function update(string $id, array $data)
    {
        $city = City::find($id);

        if ($city) {
            $city->update($data);
            return $city;
        }

        return null;
    }

    public function delete(string $id): bool
    {
        $city = City::find($id);

        if ($city) {
            return $city->delete();
        }

        return false;
    }
}
