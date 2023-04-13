<?php

namespace App\Services\Auth\Jwt;

use Illuminate\Support\Str;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authentication {


    protected $userId;

    protected $user;


    public function setUserId(int $userId) : void
    {
        $this->userId = $userId;
    }

    public function setUser(User $user) : void
    {
        $this->setUserId($user->id);
        $this->user = $user;
    }


    public function authenticate() : string
    {
        if (isset($this->user))
        {
            return $this->getToken($this->user);
        }
        elseif (isset($this->userId))
        {
            $user = User::find($this->userId);
            return $this->getToken($user);
        }
        else {
            throw new \Exception("Users not set");
        }
    }

    private function getToken(User $user) : string
    {
        return JWTAuth::fromUser($user);
    }



}
