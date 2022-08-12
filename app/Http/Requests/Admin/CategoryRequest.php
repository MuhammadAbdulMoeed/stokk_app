<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required',
            'icon' => 'mimes:png,jpg,jpeg',
            'checkout_type' => 'required_without:parent_id',
            'image' => 'mimes:png,jpg,jpeg'
        ];
    }

    public function messages()
    {
        return [
            'checkout_type.required_without' => "Checkout Type is a required field"
        ];
    }
}
