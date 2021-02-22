<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractStoreRequest extends FormRequest
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
            'contract_no' => 'required',
            'client_id' => 'required|not_in:0',
            'trade_name' => 'required',
            'billing_address' => 'required',
            'tin' => 'required',
            'contact_person' => 'required',
            'contact_no' => 'required',
            'date_started' => 'required|date',
            'location_id' => 'required|not_in:0',
            // 'services' => 'sometimes|array|min:1',
            'charges' => 'sometimes|array|min:1'
        ];
    }

    public function attributes()
    {
        return [
            'client_id' => 'client',
            'location_id' => 'location'
        ];
    }

    public function messages()
    {
        return [
            'not_in' => 'The :attribute field is required.'
        ];
    }
}
