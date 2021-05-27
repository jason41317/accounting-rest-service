<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemSettingUpdateRequest extends FormRequest
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
            'billing_cutoff_day' => 'required',
            'accounts_receivable_account_title_id' => 'required',
            'operating_expense_account_class_id' => 'required',
            'cash_account_title_id' => 'required',
            'service_income_account_class_id' => 'required',
            'other_income_account_class_id' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'accounts_receivable_account_title_id' => 'accounts receivable account title',
            'operating_expense_account_class_id' => 'operating expense account class',
            'cash_account_title_id' => 'cash account title',
            'service_income_account_class_id' => 'service income account class',
            'other_income_account_class_id' => 'other income account class'
        ];
    }
}
