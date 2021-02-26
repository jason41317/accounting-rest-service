<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountClassUpdateRequest extends FormRequest
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
            'name' => 'required',
            'account_type_id' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'account_type_id' => 'account type'
        ];
    }
}
