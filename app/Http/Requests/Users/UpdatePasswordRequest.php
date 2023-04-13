<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\APIValidationException;
use Hash;

class UpdatePasswordRequest extends FormRequest
{

    public $currentPassword;
    public $newPassword;

    public function rules()
    {
        return [
            'current_password'=> 'required|min:7',
            'new_password'=> 'required|min:7',
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
        $this->currentPassword = $this->input('current_password');
        $this->newPassword = Hash::make($this->input('new_password'));
    }

    /**
     * Get Request data as an array
     *
     * @return array
     */
    public function getData() : array
    {
        return [
            'current_password' => $this->currentPassword,
            'new_password' => $this->newPassword,
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
