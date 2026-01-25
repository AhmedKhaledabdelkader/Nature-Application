<?php

namespace App\Repositories\Contracts;

interface ServiceV2RepositoryInterface
{

    public function create(array $data) ;

     public function find(string $id) ;

     public function delete(string $id) ;

     public function getAll($page, $size) ;

    public function search(string $key, string $value, int $page, int $size);

     public function getAllServicesNames() ;



     
    
}
