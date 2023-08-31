<?php

namespace App\Http\Controllers;

use App\Services\LivroService;
use App\Repositories\LivroRepository;
use Illuminate\Http\Request;

class LivrosController extends Controller
{
    protected $livroService;
    protected $livroRepository;

    public function __construct(LivroService $livroService, LivroRepository $livroRepository)
    {
        $this->livroService = $livroService;
        $this->livroRepository = $livroRepository;
    }

    public function criarLivroApi(Request $request)
{
    $dados = $request->all();
    $resultado = $this->livroService->criarLivro($dados);

    if (isset($resultado['message'])) {
        return response()->json($resultado['message'], $resultado['status']);
    } else {
        return response()->json($resultado['errors'], $resultado['status']);
    }
}



    public function pesquisarLivroApi(Request $request, $name)
    {
        $resultado = $this->livroService->pesquisarLivro($name);

        return response()->json($resultado['livro'], $resultado['status']);
    }

    public function editarLivroApi(Request $request, $id)
    {
        $dados = $request->all();
        $resultado = $this->livroService->editarLivro($id, $dados);

        return response()->json($resultado['message'], $resultado['status']);
    }

    public function excluirLivroApi($id)
    {
        $resultado = $this->livroService->excluirLivro($id);

        return response()->json($resultado['message'], $resultado['status']);
    }
}
