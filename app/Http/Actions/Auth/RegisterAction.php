<?php

namespace App\Http\Actions\Auth;

use App\Services\Auth\Jwt\Authentication as JwtAuthentication;
use App\Services\Users\UsersService;

class RegisterAction
{

    public function execute($registerData)
    {
        $user = UsersService::createUser($registerData->name, $registerData->email, $registerData->password);
        $jwtAuth = new JwtAuthentication();
        $jwtAuth->setUser($user);
        return [
            'user' => $user
        ];
    }
}
