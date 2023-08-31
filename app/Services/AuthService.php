<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function attemptLogin($credentials)
    {
        return Auth::attempt($credentials);
    }

    public function getUser()
    {
        return Auth::user();
    }
}
