<?php

namespace App\Repositories\Eloquents;

use App\Models\Sponsor;
use App\Repositories\Contracts\SponsorRepositoryInterface;

class SponsorRepository implements SponsorRepositoryInterface
{

    public function create(array $data)
    {
        return Sponsor::create($data);
    }

    public function find(string $id)
    {
        return Sponsor::find($id);
    }
 
}
