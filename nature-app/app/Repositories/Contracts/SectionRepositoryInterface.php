<?php

namespace App\Repositories\Contracts;

interface SectionRepositoryInterface
{


     public function createWithSubsections(array $data) ;


     public function find(string $id);
    
}
