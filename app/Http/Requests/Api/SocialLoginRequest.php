<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SocialLoginRequest extends FormRequest
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
            'full_name' => 'required',
            'uuid' => 'required|string',
            "provider" => "required|string|in:FACEBOOK,GMAIL,APPLE",
            'image' => 'mimes:png,jpeg,jpg',
            'email' => 'required_if:provider,GMAIL',
            'fcm_token' => 'required',
//            'country' => 'required',
//            'city' => 'required',
//            'country_lat' => 'required',
//            'country_lng' => 'required',
//            'city_lat' => 'required',
//            'city_lng' => 'required'
        ];
    }

    public function messages() //OPTIONAL
    {
        return [
            'email.required_if' => 'The email field is required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            makeResponse('error', $validator->errors()->first(),422)
        );
    }
}
