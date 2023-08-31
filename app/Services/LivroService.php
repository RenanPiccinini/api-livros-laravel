<?php

namespace App\Services;

use App\Models\Livro;
use Illuminate\Support\Facades\Validator;

class LivroService
{
    public function criarLivro(array $dados)
    {
        $validator = $this->validacoesLivro($dados);

        if ($validator->fails()) {
            return ['status' => 422, 'errors' => $validator->errors()];
        }

        $livro = new Livro;
        $livro->name = $dados['name'];
        $livro->isbn = $dados['isbn'];
        $livro->valor = $dados['valor'];
        $livro->save();

        return ['status' => 201, 'message' => 'Livro ' . $livro->name . ' registrado com sucesso!'];
    }


    public function pesquisarLivro($name)
    {
        $livro = Livro::where('name', $name)->first();

        if (!$livro) {
            return ['status' => 404, 'message' => 'Livro não encontrado'];
        }

        return ['status' => 200, 'livro' => $livro];
    }

    public function editarLivro($id, array $dados)
    {
        $validator = $this->validacoesLivro($dados);

        $livro = Livro::find($id);

        if (!$livro) {
            return ['status' => 404, 'message' => 'Livro não encontrado'];
        }

        if ($validator->fails()) {
            return ['status' => 422, 'errors' => $validator->errors()];
        }

        $livro->name = $dados['name'];
        $livro->isbn = $dados['isbn'];
        $livro->valor = $dados['valor'];
        $livro->save();

        return ['status' => 200, 'message' => 'Livro ' . $livro->name . ' atualizado com sucesso'];
    }

    public function excluirLivro($id)
    {
        $livro = Livro::find($id);

        if (!$livro) {
            return ['status' => 404, 'message' => 'Livro não encontrado'];
        }

        $livro->delete();

        return ['status' => 200, 'message' => 'Livro excluído com sucesso'];
    }

    public function validacoesLivro(array $dados)
    {
        $validator = Validator::make($dados, [
            'name' => 'required',
            'isbn' => 'required|numeric',
            'valor' => 'required|numeric',
        ], [
            'name.required' => 'Campo nome do livro é obrigatório',
            'isbn.required' => 'Campo ISBN é obrigatório',
            'isbn.numeric' => 'Campo ISBN deve ser numérico',
            'valor.required' => 'Campo Valor é obrigatório',
            'valor.numeric' => 'Campo Valor deve ser numérico',
        ]);

        return $validator;
    }
}
