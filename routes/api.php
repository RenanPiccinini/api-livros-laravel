<?php

use App\Http\Controllers\LivrosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register-api', [RegisterController::class, 'registerApi']);
Route::post('/login-api', [LoginController::class, 'loginApi']);
Route::post('/logout-api', [LogoutController::class, 'logoutApi']);

Route::post('/criar-livro-api', [LivrosController::class, 'criarLivroApi']);
Route::get('/pesquisar-livro-api/{name}', [LivrosController::class, 'pesquisarLivroApi']);
Route::put('/editar-livros-api/{id}', [LivrosController::class, 'editarLivroApi']);
Route::delete('/excluir-livros-api/{id}', [LivrosController::class, 'excluirLivroApi']);



