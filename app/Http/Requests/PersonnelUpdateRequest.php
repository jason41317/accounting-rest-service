<?php

namespace App\Http\Requests;

use App\Rules\IsOldPasswordMatched;
use Illuminate\Foundation\Http\FormRequest;

class PersonnelUpdateRequest extends FormRequest
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
            'first_name' => 'sometimes|required',
            'last_name' => 'sometimes|required',
            'birth_date' => 'sometimes|required|date',
            'user.username' => 'sometimes|required|email|unique:users,username,' . $this->id . ',userable_id',
            'user.old_password' => ['sometimes', 'required', new IsOldPasswordMatched()],
            'user.password' => 'sometimes|required|min:6|confirmed',
            'user.user_group_id' => 'sometimes|required'
        ];
    }

    public function attributes()
    {
        return [
            'user.username' => 'username',
            'user.old_password' => 'old password',
            'user.password' => 'password',
            'user.user_group_id' => 'user group'
        ];
    }
}
