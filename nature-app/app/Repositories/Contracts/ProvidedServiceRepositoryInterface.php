<?php

namespace App\Repositories\Contracts;

interface ProvidedServiceRepositoryInterface
{

    public function create(array $data) ;
    
    public function find(string $id) ;

    public function all($page, $size) ;

     public function delete(string $id) ;


  


    
}
