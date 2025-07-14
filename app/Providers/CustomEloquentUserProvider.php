<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class CustomEloquentUserProvider extends EloquentUserProvider
{
    public function validateCredentials(UserContract $user, array $credentials)
    {
       $plain = $credentials['password'];

        $hash_info = Hash::info($user->getAuthPassword());
        if($hash_info['algoName']=="bcrypt"){
            return $this->hasher->check($plain, $user->getAuthPassword());
        }else{
            return $plain == Crypt::decryptString($user->getAuthPassword());
        }
    }

}
