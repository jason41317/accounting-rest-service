<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisbursementStoreRequest extends FormRequest
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
            // 'voucher_no' => 'required|max:191|unique:disbursements,voucher_no,'.$this->id,
            'payee' => 'required|max:191',
            'address' => 'required',
            'bank_id' => 'required|not_in:0',
            'cheque_no' => 'required|max:191',
            'cheque_date' => 'required',
            'cheque_amount' => 'required|gt:0',
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
