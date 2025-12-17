<?php

namespace App\Repositories\Contracts;

interface CityRepositoryInterface
{
    //public function all($page,$size);

   public function find(string $id);

    public function allByCountry(string $countryId, int $page, int $size);

    public function create(array $data);

  public function update(string $id, array $data);

    public function delete(string $id);
}
