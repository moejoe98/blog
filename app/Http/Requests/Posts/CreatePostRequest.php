<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\APIValidationException;

class CreatePostRequest extends FormRequest
{

    public $content;

    public function rules()
    {
        return [
            'content'=> 'required|min:1',
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
        $this->content = $this->input('content');
    }

    /**
     * Get Request data as an array
     *
     * @return array
     */
    public function getData() : array
    {
        return [
            'content' => $this->content,
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
