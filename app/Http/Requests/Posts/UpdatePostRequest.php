<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\APIValidationException;
use Hash;

class UpdatePostRequest extends FormRequest
{

    public $post_id;
    public $content;

    public function rules()
    {
        return [
            'post_id' => 'required|exists:posts,id',
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
        $this->post_id = $this->input('post_id');
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
            'post_id' => $this->post_id,
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
