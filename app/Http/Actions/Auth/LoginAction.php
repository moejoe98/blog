<?php

namespace App\Http\Actions\Auth;

use App\Services\Auth\Jwt\Authentication as JwtAuthentication;
use App\Exceptions\WrongCredentialsException;
use App\Services\Users\UsersService;
use App\Services\Balances\BalancesService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Hash;

class LoginAction
{

    public function execute($credentials)
    {
        $user = UsersService::getUserByEmail($credentials['email']);
        if (isset($user)) {
            if (Hash::check($credentials['password'], $user->password))
            {
            if (Hash::needsRehash($user->password)) {
                    $user->password = Hash::make($credentials['password']);
                    $user->save();
                }


                $token = JWTAuth::fromUser($user);
                    return [
                        'auth_token' => $token,
                        'user' => $user
                    ];
            }
            else {
                throw new WrongCredentialsException();
            }
        }
        else {
            throw new WrongCredentialsException();
        }
    }
}
