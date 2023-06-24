<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function registerApi(Request $request)
    {
        $validator = $this->validacoesUsuario($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
        }

        return response()->json(['message' => 'Usuario ' . $user->name . ' registrado com sucesso!'], 201);
    }

    public function validacoesUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[^@]+@[^@]+\.[^@]+$/', 'unique:'.User::class],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%#?&])[A-Za-z\d@$!%#?&]+$/'
            ],

        ], [
            'name.required' => 'Campo nome e obrigatorio',
            'name.min' => 'O campo nome deve ter no minimo 3 caracteres',
            'email.email' => 'O e-mail precisa conter um @ para ser valido',
            'email.unique' => 'O e-mail informado ja esta sendo utilizado',
            'password.regex' => 'A senha deve ter pelo menos 1 caractere numerico, 1 caractere especial e 1 letra maiuscula',
            'password.min' => 'A senha deve conter no minimo 8 caracteres',
            'email.regex' => 'O e-mail deve conter um . apos o @ para ser valido',
            "password.confirmed" => "A confirmacao da senha nao corresponde.",
        ]);

        return $validator;
    }
}
