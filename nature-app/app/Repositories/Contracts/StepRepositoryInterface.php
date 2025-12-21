<?php

namespace App\Repositories\Contracts;

interface StepRepositoryInterface
{
    public function create(array $data) ;


    public function find(string $id) ;

    public function delete(string $id);


}
