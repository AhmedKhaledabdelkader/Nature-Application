<?php

namespace App\Repositories\Contracts;

interface TestimonialRepositoryInterface
{


    public function create(array $data) ;


     public function find(string $id) ;


     
     public function delete(string $id) ;


      public function all($page, $size) ;





    
}
