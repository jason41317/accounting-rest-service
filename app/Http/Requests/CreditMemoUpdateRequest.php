<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditMemoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'contract_id' => 'required|not_in:0',
            'month_id' => 'required|not_in:0',
            'credit_memo_date' => 'required|date',
            'charges' => 'sometimes|array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'not_in' => 'The :attribute field is required.'
        ];
    }

    public function attributes()
    {
        return [
            'contract_id' => 'contract',
            'month_id' => 'month and year',
        ];
    }
}
