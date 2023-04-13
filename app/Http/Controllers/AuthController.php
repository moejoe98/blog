<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Actions\Auth\LoginAction;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Actions\Auth\RegisterAction;
use App\Http\Requests\Auth\RegisterRequest;
use App\Exceptions\WrongCredentialsException;


class AuthController extends Controller
{

    public function login(LoginRequest $request, LoginAction $action)
    {
        $request->email = strtolower($request->email);
        $credentials = $request->only('email', 'password');

        try {
            $token = $action->execute($credentials);
            return $this->successResponse(true, 'Success', $token);
        }
        catch (WrongCredentialsException $exception)
        {
            return $this->errorResponse(422, ('Wrong Credentials'));
        }

        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }

    public function register(RegisterRequest $request, RegisterAction $action)
    {
        $request->email = strtolower($request->email);

        try {
            $token  = $action->execute($request);
            return $this->successResponse(true, 'Success', $token);
        }
        catch (\Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }

    }
}
