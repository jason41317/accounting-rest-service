<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BillingPeriodUpdateRequest extends FormRequest
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
            'month_id' => Rule::unique('billing_periods', 'month_id')->ignore($this->id)->where('year', $this->year)
            //Rule::unique('subjects', 'description')->ignore($this->id)->where('name', $this->name)
        ];
    }

    public function attributes()
    {
        return [
            'month_id' => 'month and year',
        ];
    }
}
