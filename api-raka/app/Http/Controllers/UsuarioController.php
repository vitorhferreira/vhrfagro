<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail; // Classe mailable que envia o e-mail

class UsuarioController extends Controller
{
    /**
     * Exibir todos os usuários sem as senhas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('id', 'nome', 'cpf', 'email')->get(); // Excluir campo 'senha'
        return response()->json($users);
    }

    /**
     * Solicitar redefinição de senha.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function solicitarRedefinicaoSenha(Request $request)
    {
        // Validação do e-mail
        $request->validate([
            'email' => 'required|string|email',
        ]);

        // Busca o usuário pelo e-mail
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        // Gera um token único e aleatório
        $token = Str::random(60);

        // Armazena o token na tabela 'password_resets'
        PasswordReset::create([
            'email' => $user->email,
            'token' => $token,
            'created_at' => Carbon::now(), // Armazena a data de criação do token
        ]);

        // Gera o link de redefinição de senha com o token, apontando para o front-end
        $resetLink = "http://localhost:3000/resetsenha?token={$token}";

        // Envia o e-mail de redefinição de senha para o usuário
        Mail::to($user->email)->send(new ResetPasswordMail($resetLink));

        return response()->json(['message' => 'E-mail de redefinição de senha enviado.']);
    }

    /**
     * Redefinir a senha do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function redefinirSenha(Request $request)
    {
        // Validação do token e da nova senha
        $request->validate([
            'token' => 'required|string',
            'senha' => 'required|string|min:6',
        ]);

        // Busca o token na tabela 'password_resets'
        $reset = PasswordReset::where('token', $request->token)->first();

        if (!$reset) {
            return response()->json(['error' => 'Token inválido ou expirado'], 400);
        }

        // Verifica se o token expirou (tempo de expiração: 30 minutos)
        if (Carbon::now()->diffInMinutes($reset->created_at) > 30) {
            return response()->json(['error' => 'Token expirado. Solicite uma nova redefinição de senha.'], 400);
        }

        // Busca o usuário pelo e-mail associado ao token
        $user = User::where('email', $reset->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado.'], 404);
        }

        // Atualiza a senha do usuário
        $user->senha = Hash::make($request->senha);
        $user->save();

        // Apaga o token da tabela 'password_resets'
        PasswordReset::where('token', $request->token)->delete();

        return response()->json(['message' => 'Senha redefinida com sucesso.']);
    }

    /**
     * Logar o usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $dados = $request->only('cpf', 'senha');

        // Buscar o usuário pelo CPF
        $user = User::where('cpf', $dados['cpf'])->first();

        if ($user && Hash::check($dados['senha'], $user->senha)) {
            // Login bem-sucedido
            return response()->json(['message' => 'Login bem sucedido', 'user' => $user], 200);
        } else {
            // CPF ou senha inválidos
            return response()->json(['message' => 'CPF ou senha inválidos'], 401);
        }
    }

    /**
     * Cadastrar um novo usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $dados = $request->only(['nome', 'cpf', 'email', 'senha']);

            // Validação do CPF e email
            $request->validate([
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|size:11|unique:users',
                'email' => 'required|email|unique:users',
                'senha' => 'required|string|min:6',
            ]);

            // Criptografar a senha antes de armazenar
            $dados['senha'] = Hash::make($dados['senha']);

            // Cadastrar o usuário no banco de dados
            $user = User::create($dados);

            return response()->json($user, 201);
        } catch (\Illuminate\Database\QueryException $e) {
            // Exceção por chave única violada
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['error' => 'CPF ou email já cadastrados'], 400);
            }

            return response()->json(['error' => 'Erro de banco de dados'], 500);
        }
    }

    /**
     * Atualizar os dados de um usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|size:11',
            'email' => 'required|string|email|max:255',
        ]);

        try {
            $user = User::findOrFail($id);

            // Atualiza os dados
            $user->update($request->all());

            return response()->json(['message' => 'Usuário atualizado com sucesso', 'sucesso' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar usuário', 'erro' => $e->getMessage()], 500);
        }
    }

    /**
     * Deletar um usuário.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'Usuário deletado com sucesso', 'sucesso' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar usuário', 'erro' => $e->getMessage()], 500);
        }
    }
}
