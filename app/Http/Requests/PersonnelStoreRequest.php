<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonnelStoreRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required|date',
            'user.username' => 'required|email|unique:users,username',
            'user.password' => 'required|min:6|confirmed',
            'user.user_group_id' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'user.username' => 'username',
            'user.password' => 'password',
            'user.user_group_id' => 'user group'
        ];
    }
}
