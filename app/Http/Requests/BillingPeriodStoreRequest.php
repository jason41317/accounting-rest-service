<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BillingPeriodStoreRequest extends FormRequest
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
            'month_id' => 'required|'.Rule::unique('billing_periods', 'month_id')->where('year', $this->year),
        ];
    }

    public function attributes()
    {
        return [
            'month_id' => 'month and year',
        ];
    }
}
