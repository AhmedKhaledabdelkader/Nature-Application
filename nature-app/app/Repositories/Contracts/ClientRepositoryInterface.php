<?php

namespace App\Repositories\Contracts;

interface ClientRepositoryInterface
{
    
    public function create(array $data);

    public function find(string $id);

    public function getAll($page,$size) ;

    public function delete(string $id);
    
}
