<?php

namespace App\Repositories\Contracts;

interface AwardRepositoryInterface
{

 public function all($page, $size);

    public function find(string $id);

   public function create(array $data);

  //  public function update(string $id, array $data);

  //  public function delete(string $id);
    
}
