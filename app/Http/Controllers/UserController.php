<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Services\Users\UsersService;
use App\Exceptions\WrongCredentialsException;
use App\Http\Actions\Users\DeleteUserAction;
use App\Http\Actions\Users\UpdateProfileAction;
use App\Http\Actions\Users\UpdatePasswordAction;
use App\Http\Requests\Users\UpdateProfileRequest;
use App\Http\Requests\Users\UpdatePasswordRequest;

class UserController extends Controller
{

    public function getUserProfile()
    {
        try {
            $data = UsersService::getUserById(JWTAuth::user()->id);
            return $this->successResponse(true, 'Success', $data);
        }
        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function updateUserProfile(UpdateProfileRequest $request, UpdateProfileAction $action)
    {
        try {
            $data = $action->execute(JWTAuth::user()->id, $request->getData());
            return $this->successResponse(true, 'Success', $data);
        }
        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function updateUserPassword(UpdatePasswordRequest $request, UpdatePasswordAction $action)
    {
        try {
            $data = $action->execute(JWTAuth::user()->id, $request->currentPassword, $request->newPassword);
            return $this->successResponse(true, 'Success', $data);
        }
        catch (WrongCredentialsException $exception)
        {
            return $this->errorResponse(422, ('Wrong Current Password'));
        }
        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function deleteAccount(DeleteUserAction $action)
    {
        $userId = JWTAuth::user()->id;
        try {
            $action->execute($userId);
            return $this->successResponse(true, 'Success');
        }
        catch(\Exception $e)
        {
            return $this->errorResponse(500, $e->getMessage());
        }
    }

}
