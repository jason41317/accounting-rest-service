<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountTitleUpdateRequest extends FormRequest
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
            'code' => 'required|unique:account_titles,code,' . $this->id,
            'name' => 'required',
            'account_class_id' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'account_class_id' => 'account class'
        ];
    }
}
