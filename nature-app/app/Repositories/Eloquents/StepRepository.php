<?php

namespace App\Repositories\Eloquents;

use App\Models\step;
use App\Repositories\Contracts\StepRepositoryInterface;

class StepRepository implements StepRepositoryInterface
{


    public function create(array $data)
    {
        return step::create($data) ;
    }


     public function find(string $id)
    {
        return step::find($id);
    }

   public function delete(string $id): bool
    {
        $step = step::find($id);
        if ($step) {
            return $step->delete();
        }
        return false;
    }







}
