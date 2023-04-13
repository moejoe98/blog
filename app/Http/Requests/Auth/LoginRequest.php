<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\APIValidationException;

class LoginRequest extends FormRequest
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new APIValidationException($validator);
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $this->email = $this->input('email');
        $this->password = $this->input('password');
    }

    /**
     * Get Request data as an array
     *
     * @return array
     */
    public function getData() : array
    {
        return [
            'email' => $this->email,
            'password' => $this->password
        ];
    }

    /**
     * Get Request data as an object
     *
     * @return array
     */
    public function getDataObject() : object
    {
        return (object) $this->getData();
    }

}
