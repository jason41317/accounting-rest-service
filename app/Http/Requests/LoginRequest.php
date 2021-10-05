<?php

namespace App\Http\Requests;

use App\Rules\IsUserFound;
use App\Rules\IsUserMatchPword;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'username' => ['required', new IsUserFound()],
            'password' => [
                'required',
                'min:6',
                new IsUserMatchPword(
                    $this->username
                )
            ],
        ];
    }
}
