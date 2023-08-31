<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function loginApi(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($this->authService->attemptLogin($credentials)) {
            $user = $this->authService->getUser();

            return response()->json([
                'message' => 'Login realizado com sucesso!',
                'Nome' => $user->name,
            ]);
        } else {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }
    }
}
