<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillingUpdateRequest extends FormRequest
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
            'client_id' => 'required|not_in:0',
            'contract_id' => 'required|not_in:0',
            'billing_date' => 'required|date',
            'due_date' => 'required|date',
            'charges' => 'sometimes|array|min:1'
        ];
    }

    public function attributes()
    {
        return [
            'client_id' => 'client',
            'contract_id' => 'contract'
        ];
    }

    public function messages()
    {
        return [
            'not_in' => 'The :attribute field is required.'
        ];
    }
}
