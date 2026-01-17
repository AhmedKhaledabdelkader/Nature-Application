<?php

namespace App\Repositories\Contracts;

interface ClientSectionRepositoryInterface
{
    
    public function create(array $data) ;

    public function find(string $id);

    public function getAll($page,$size) ;

    public function search(string $keyword, int $page, int $size);
 
    public function delete(string $id);



}
