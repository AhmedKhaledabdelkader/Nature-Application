<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public $userService ;


    public function __construct(UserService $userService) {
        

        $this->userService=$userService ;

    }

    
    public function register(Request $request)
    {

   

        $user=$this->userService->createUser($request->all()) ; 

       return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully. Please check your email to verify your account.',
            'result'=>$user
        ], 201);



    }

     public function verify($id, $hash)
    {
        return $this->userService->verify($id, $hash);
    }




    public function login(Request $request){


  $result = $this->userService->authenticateUser($request->all());

           
            if (is_array($result)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login to the system successfully',
                    'user' => $result['user'],
                    'token' => $result['token'],
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => $result,
            ], 401);

    }

    
}
