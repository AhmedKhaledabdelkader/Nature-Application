<?php

namespace App\Repositories\Eloquents;

use App\Models\Award;
use App\Repositories\Contracts\AwardRepositoryInterface;

class AwardRepository implements AwardRepositoryInterface
{

    public function create(array $data)
    {
        return Award::create($data);
    }

    public function find(string $id)
    {
        return Award::find($id);

    }

public function findWithSponsors(string $id)
{
    return Award::with('sponsors')->find($id);
}


    public function all($page, $size)
    {
 
         return Award::query()->paginate($size,['*'],'page',$page);
    }

    public function delete(string $id): bool
    {
        $award = Award::find($id);

        if ($award) {
            return $award->delete();
        }

        return false;
    }
   
}
