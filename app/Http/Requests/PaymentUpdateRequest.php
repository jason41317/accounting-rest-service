<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentUpdateRequest extends FormRequest
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
            'transaction_no' => 'sometimes|required',
            'client_id' => 'sometimes|required|not_in:0',
            'contract_id' => 'sometimes|required|not_in:0',
            'amount' => 'sometimes|required|gt:0',
            'transaction_date' => 'sometimes|required|date',
            'payment_type_id' => 'sometimes|required|not_in:0',
            'bank_id' => 'sometimes|required_if:payment_type_id,2,3',
            'ewallet_id' => 'sometimes|required_if:payment_type_id,4',
            'reference_no' => 'sometimes|required_unless:payment_type_id,1',
            'reference_date' => 'sometimes|required_unless:payment_type_id,1',
            'charges' => 'sometimes|array|min:1',
            // 'approved_notes' => 'sometimes|required',
            'deposit_date' => 'sometimes|required|date',
            'payment_status_id' => 'sometimes|required',
        ];
    }

    public function attributes()
    {
        return [
            'client_id' => 'client',
            'contract_id' => 'contract',
            'payment_type_id' => 'payment type',
            'bank_id' => 'bank',
            'ewallet_id' => 'e-wallet',
            'payment_status_id' => 'payment status',
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
