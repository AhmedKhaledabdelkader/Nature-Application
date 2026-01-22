<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;

class UserService
{
    public $userRepository ;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository=$userRepository ;
    }


    public function createUser(array $data)
    {
        $user=$this->userRepository->create($data);

        return $user ;

    }


    
      public function verify($id, $hash)
{
    $user = $this->userRepository->findById($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
    
       return view('emails.verified-error');
    }

    if ($user->hasVerifiedEmail()) {
  
       return view('emails.already-verified');
    }

    $user->markEmailAsVerified();
    event(new Verified($user));

 
   return view('emails.verified-success');


}

public function authenticateUser(array $data){


$user=$this->userRepository->findByUsername($data["username"]);


if ($user) {
    
if (Hash::check($data["password"], $user->password)) {

if (!is_null($user->email_verified_at)) {

     $token = $user->createToken('api_token')->plainTextToken;

    return [
        'user'  => $user,
        'token' => $token,
    ];
    
}
else{

    return "verification email is needed" ;

}


}

else{

    return "password is incorrect" ;

}

}

else{

return "username not found ";

}

}


 public function logoutCurrentDevice(Request $request)
    {
        $token = $request->attributes->get('accessToken');

        if ($token) {
            $token->delete();
        }

        return ['status'=>'success','message' => 'Logged out from the current device'];
    }

    /**
     * Logout from all devices
     */
    public function logoutAllDevices($user)
    {
        $user->tokens()->delete();

        return ['status'=>'success','message' => 'Logged out from all devices'];
    }




}
