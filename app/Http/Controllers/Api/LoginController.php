<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Realiza a autenticação do usuário.
     *
     * Este método tenta autenticar o usuário com as credenciais fornecidas.
     * Se a autenticação for bem-sucedida, retorna o usuário autenticado juntamente com um token de acesso.
     * Se a autenticação falhar, retorna uma mensagem de erro.
     *
     * @param \Illuminate\Http\Request $request O objeto de requisição HTTP contendo as credenciais do usuário (email e senha).
     * @return \Illuminate\Http\JsonResponse Uma resposta JSON contendo o usuário autenticado e um token de acesso se a autenticação for bem-sucedida, ou uma mensagem de erro se a autenticação falhar.
     */
    public function login(Request $request): JsonResponse
    {
        // Validar o e-mail e a senha
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            // Recuperar os dados do usuário
            $user = Auth::user();

            $token = $request->user()->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user,                
            ], 201);

        }else{
            return response()->json([
                'status' => false,
                'message' => 'Login ou senha incorreta.',
            ], 404);
        }
    }

    /**
     * Realiza o logout do usuário.
     *
     * Este método revoga todos os tokens de acesso associados ao usuário, efetuando assim o logout.
     * Se o logout for bem-sucedido, retorna uma resposta JSON indicando sucesso.
     * Se ocorrer algum erro durante o logout, retorna uma resposta JSON indicando falha.
     *
     * @param \App\Models\User $user O usuário para o qual o logout será efetuado.
     * @return \Illuminate\Http\JsonResponse Uma resposta JSON indicando o status do logout e uma mensagem correspondente.
     */
    public function logout(User $user): JsonResponse
    {
        try{

            $user->tokens()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Deslogado com sucesso.',
            ], 200);

        } catch (Exception $e){

            return response()->json([
                'status' => false,
                'message' => 'Não deslogado.',
            ], 400);

        }
    }
}
