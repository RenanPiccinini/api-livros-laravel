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

    public function pesquisarLivroApi(Request $request, $name)
    {
        $livro = Livro::where('name', $name)->first();

        if (!$livro) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        return response()->json(['livro' => $livro], 200);
    }

    public function editarLivroApi(Request $request, $id)
    {
        $validator = $this->validacoesLivro($request);

        $livro = Livro::find($id);

        if (!$livro) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $livro->name = $request->input('name');
            $livro->isbn = $request->input('isbn');
            $livro->valor = $request->input('valor');
            $livro->save();
        }

        return response()->json(['message' => 'Livro ' . $livro->name . ' atualizado com sucesso'], 200);
    }


}
