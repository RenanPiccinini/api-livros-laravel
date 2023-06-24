<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


class LogoutController extends Controller
{
    public function logoutApi()
    {
        Auth::logout();

        return response()->json(['message' => 'Logout realizado com sucesso!']);
    }
}
