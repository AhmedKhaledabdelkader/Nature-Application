<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    
    public function create(array $data)
    {
        return User::create($data) ;
        
    }


    public function findById($id)
    {
        return User::findOrFail($id);
    }


    public function findByUsername(string $username){



     return User::where("username",$username)->first() ;


     }





    
}
