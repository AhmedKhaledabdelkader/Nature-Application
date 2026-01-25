<?php

namespace App\Repositories\Contracts;

interface ProjectRepositoryInterface
{


    public function create(array $data) ;

     public function find(string $id) ;

     
    public function all($page, $size);


    public function delete(string $id) ;

   public function search(string $key, string $value, int $page, int $size);

}
