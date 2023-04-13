<?php

namespace App\Services\Users;

use App\Exceptions\NoSuchUserException;
use App\Models\User;
use Illuminate\Support\Str;

class UsersService {


    public static function createUser($name, $email, $password)
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }

    public static function getUserByEmail(string $email)
    {
        return User::where('email', 'like', $email)->first();
    }

    public static function getUserById($userId)
    {
        $data =  User::find($userId);
        return $data;
    }

    public static function getUsersCount()
    {
        return User::count();
    }


    public static function updateUserProfile($userId, $data)
    {
        return User::updateOrCreate(['id' => $userId],$data);
    }

    public static function deleteUserById($userId)
    {
        $user = User::find($userId);
        if (isset($user))
            return $user->delete();
        else throw new NoSuchUserException();
    }

    public static function restoreUserById($userId){
        $user = User::withTrashed()->find($userId);
        if(isset($user))
        return $user->restore();
        else throw new NoSuchUserException();
    }
}
