<?php

namespace App\Repositories\Contracts;

interface ServiceV2RepositoryInterface
{

    public function create(array $data) ;

     public function find(string $id) ;

     public function delete(string $id) ;
    
}
