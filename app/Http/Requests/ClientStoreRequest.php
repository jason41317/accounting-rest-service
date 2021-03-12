<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
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
            'code' => 'required|max:191|unique:clients,code,'.$this->id,
            'name' => 'required|max:191',
            'office_address' => 'required',
            'business_style_id' => 'required|not_in:0',
            'business_type_id' => 'required|not_in:0',
            'email' => 'email|nullable|max:191',
            'owner' => 'max:191',
            'contact_no' => 'max:191',
            'rdo_no' => 'max:191',
            'industry' => 'max:191',
            'sec_dti_no' => 'max:191'
        ];
    }

    public function attributes() 
    {
        return [
            'business_style_id' => 'business style',
            'business_type_id' => 'business type'
        ];
    }

    public function messages()
    {
        return [
            'not_in' => 'The :attribute field is required.'
        ];
    }
}
