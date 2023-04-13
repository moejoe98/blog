<?php

namespace App\Http\Actions\Users;

use App\Services\Auth\Jwt\Authentication as JwtAuthentication;
use App\Exceptions\WrongCredentialsException;
use App\Services\Users\UsersService;
use Tymon\JWTAuth\Facades\JWTAuth;


class UpdatePasswordAction
{

    public function execute($userId, $currentPassword, $newPassword)
    {
        $user = UsersService::getUserById($userId);
        if (!JWTAuth::attempt(['email' => $user->email, 'password' => $currentPassword]))
            throw new WrongCredentialsException();
        else
            return UsersService::updateUserProfile($userId, ['password' => $newPassword]);
    }
}
