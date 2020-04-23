<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedback extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => 'required',
            'h-captcha-response' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'h-captcha-response.required' => 'Please verify that you\'re not a robot.',
        ];
    }
}
