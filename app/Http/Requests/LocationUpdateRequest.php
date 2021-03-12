<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationUpdateRequest extends FormRequest
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
            'rdo_id' => 'required|not_in:0',
        ];
    }

    public function attributes()
    {
        return [
            'rdo_id' => 'rdo'
        ];
    }

    public function messages()
    {
        return [
            'not_in' => 'The :attribute field is required'
        ];
    }
}
