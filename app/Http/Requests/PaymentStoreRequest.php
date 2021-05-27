<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
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
            'transaction_no' => 'required',
            'client_id' => 'required|not_in:0',
            'contract_id' => 'required|not_in:0',
            'amount' => 'required|gt:0',
            'transaction_date' => 'required|date',
            'payment_type_id' => 'required|not_in:0',
            'bank_id' => 'required_if:payment_type_id,2,3',
            'ewallet_id' => 'required_if:payment_type_id,4',
            'reference_no' => 'required_unless:payment_type_id,1',
            'reference_date' => 'required_unless:payment_type_id,1',
            'charges' => 'sometimes|array|min:1'
        ];
    }

    public function attributes()
    {
        return [
            'client_id' => 'client',
            'contract_id' => 'contract',
            'bank_id' => 'bank',
            'ewallet_id' => 'e-wallet'
        ];
    }

    public function messages()
    {
        return [
            'required_if' => 'The :attribute field is required.',
            'required_unless' => 'The :attribute field is required.'
        ];
    }
}
