<?php

namespace App\Repositories\Contracts;

interface SponsorRepositoryInterface
{

    public function create(array $data);

    public function find(string $id);

    public function getAll($page,$size);

    public function getAllSponsorsNames() ;

    public function delete(string $id);

   

    
}
