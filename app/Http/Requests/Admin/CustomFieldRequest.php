<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomFieldRequest extends FormRequest
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
            'field_type' => 'required',
            'name' => 'required',
            'is_required' => 'required',
            'type' => 'required',
            'value_taken_from' => 'required_if:type,pre_included_field',
        ];
    }

    public function messages()
    {
        return [
            'value_taken_from.required_if' => 'Select Where Should be take data from'
        ];
    }


}
