<?php

namespace App\Repositories\Contracts;

interface ProjectMetricRepositoryInterface
{
    public function create(array $data);

    public function find(string $id) ;

    public function delete(string $id);

    public function getAll() ;


}
