<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'filter_type' => 'required',
            'filter'  => 'required_if:filter_type,pre_included_filter',
            'filter_name' => 'required_if:filter_type,pre_included_filter',
            'custom_filter_name' => 'required_if:filter_type,custom_filter',
            'field_type' => 'required_if:filter_type,custom_filter',
            'min' => 'required_if:field_type,price_range',
            'max' => 'required_if:field_type,price_range',
            'value.*' => 'required_if:field_type,simple_select_option,multi_select_option'
        ];
    }

    public function messages()
    {
        return [
            'value.*.required_if' => 'Fill All the Value Field'
        ];
    }
}
