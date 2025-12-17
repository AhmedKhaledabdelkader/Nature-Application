<?php

namespace App\Repositories\Contracts;

interface SponsorRepositoryInterface
{

    public function create(array $data);

    public function find(string $id);

    /*public function all($page,$size);

    public function update(string $id, array $data);

    public function delete(string $id);*/

   

    
}
