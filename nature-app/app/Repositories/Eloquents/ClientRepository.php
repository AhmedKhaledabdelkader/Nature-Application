<?php

namespace App\Repositories\Eloquents;

use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{

    public function create(array $data)
    {
        return Client::create($data);
    }

    public function find(string $id)
    {
        return Client::find($id);
    }


    public function getAll($page,$size){


        return Client::query()->paginate($size,['*'],'page',$page);

    }

    
    public function delete(string $id): bool
{
    $client = Client::find($id);
    
    if ($client) {
        return $client->delete();
    }
    
    return false;
}

    
}
