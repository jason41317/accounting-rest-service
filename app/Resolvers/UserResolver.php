<?php
namespace App\Resolvers;

use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\UserResolver as OwenUserResolver;


class UserResolver implements OwenUserResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve()
    {
        return Auth::check() ? Auth::user() : null;
    }
}