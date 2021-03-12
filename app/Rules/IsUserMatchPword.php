<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class IsUserMatchPword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($username)
    {
        $this->_username = $username;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::where('username', $this->_username)
            ->where('userable_type', 'App\Models\Personnel')
            ->first();
        return $user && Hash::check($value, $user->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Sorry! We couldn\'t find this user. The :attribute maybe incorrect.';
    }
}
