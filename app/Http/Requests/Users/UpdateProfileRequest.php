<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\APIValidationException;
use Illuminate\Validation\Rule;
use JWTAuth;
use Hash;

class UpdateProfileRequest extends FormRequest
{

    public $name;
    public $email;

    public function rules()
    {
        return [
            'name' => 'string|max:30|min:2',
            'email' => [
                'email',
                Rule::unique('users', 'email')->ignore(JWTAuth::user()->id, 'id')
            ],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *s
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
        $this->name = $this->input('name');
        $this->email = $this->input('email');
    }

    /**
     * Get Request data as an array
     *
     * @return array
     */
    public function getData() : array
    {
        $data = [];

        if (isset($this->email))
            $data['email'] = $this->email;

        if (isset($this->name))
            $data['name'] = $this->name;

        return $data;
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
