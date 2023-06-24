<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LivrosController extends Controller
{
    public function criarLivroApi(Request $request)
    {
        $validator = $this->validacoesLivro($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $livro = new Livro;
            $livro->name = $request->name;
            $livro->isbn = $request->isbn;
            $livro->valor = $request->valor;
            $livro->save();
        }

        return response()->json(['message' => 'Livro ' . $livro->name . ' registrado com sucesso!'], 201);
    }

    public function validacoesLivro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'isbn' => 'required|numeric',
            'valor' => 'required|numeric',
        ], [
            'name.required' => 'Campo nome do livro e obrigatorio',
            'isbn.required' => 'Campo ISBN e obrigatorio',
            'isbn.numeric' => 'Campo ISBN deve ser numerico',
            'valor.required' => 'Campo Valor e obrigatorio',
            'valor.numeric' => 'Campo Valor deve ser numerico',
        ]);

        return $validator;
    }

}
