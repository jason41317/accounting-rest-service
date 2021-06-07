<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisbursementUpdateRequest extends FormRequest
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
            // 'voucher_no' => 'sometimes|required|max:191|unique:disbursements,voucher_no,'.$this->id,
            'payee' => 'sometimes|required|max:191',
            'address' => 'sometimes|required',
            'bank_id' => 'sometimes|required|not_in:0',
            'cheque_no' => 'sometimes|required|max:191',
            'cheque_date' => 'sometimes|required',
            'cheque_amount' => 'sometimes|required|gt:0',
            'approved_notes' => 'sometimes|required',
            'rejected_notes' => 'sometimes|required',
        ];
    }

    public function attributes()
    {
        return [
            'bank_id' => 'bank',
        ];
    }

    public function messages()
    {
        return [
            'not_in' => 'The :attribute field is required.'
        ];
    }
}
