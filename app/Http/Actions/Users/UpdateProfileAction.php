<?php

namespace App\Http\Actions\Users;

use App\Services\Auth\Jwt\Authentication as JwtAuthentication;
use App\Exceptions\WrongCredentialsException;
use App\Services\Users\UsersService;
use App\Services\Users\UsersEmailsService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;


class UpdateProfileAction
{

    public function execute($userId, $profileData)
    {
        $user = JWTAuth::user();
        return UsersService::updateUserProfile($userId, $profileData);
    }

}