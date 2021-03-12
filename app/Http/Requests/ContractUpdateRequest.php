<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractUpdateRequest extends FormRequest
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
            // 'contract_no' => 'required',
            'client_id' => 'sometimes|required|not_in:0',
            'trade_name' => 'sometimes|required',
            'billing_address' => 'sometimes|required',
            'tin' => 'sometimes|required',
            'contact_person' => 'sometimes|required',
            'contact_no' => 'sometimes|required',
            'date_started' => 'sometimes|required|date',
            'location_id' => 'sometimes|required|not_in:0',
            // 'services' => 'sometimes|array|min:1',
            'charges' => 'sometimes|array|min:1',
            'assigned_to' => 'sometimes|required',
            'approved_notes' => 'sometimes|required',
            'contract_status_id' => 'sometimes|required',
        ];
    }

    public function attributes()
    {
        return [
            'client_id' => 'client',
            'location_id' => 'location',
            'assigned_to' => 'assigned personnel',
            'contract_status_id' => 'status',
        ];
    }

    public function messages()
    {
        return [
            'not_in' => 'The :attribute field is required.'
        ];
    }
}
