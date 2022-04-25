<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductSaveRequest extends FormRequest
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
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'currency' => 'required',
            'location' => 'required',
            'new_gallery.*' => 'mimes:jpg,jpeg,png'
//            'lat' => 'required',
//            'lng' => 'required'
        ];
    }
}
