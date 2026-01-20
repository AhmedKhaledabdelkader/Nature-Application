<?php

namespace App\Repositories\Contracts;

interface ServiceV2RepositoryInterface
{

    public function create(array $data) ;

     public function find(string $id) ;

     public function delete(string $id) ;

     public function getAll($page, $size) ;

     public function getAllPublishedServices($page,$size);

     public function getAllServicesNames() ;



     
    
}
