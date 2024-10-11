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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('id', 'nome', 'cpf', 'email')->get(); // Excluir campo 'senha'
        return response()->json($users);
    }

    public function solicitarRedefinicaoSenha(Request $request)
    {
        // Validação do e-mail
        $request->validate([
            'email' => 'required|string|email',
        ]);

        // Busca o usuário pelo e-mail
        $user = User::where('email', $request->email)->first();
        // Se não encontrar o usuário, retorna um erro
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

    public function redefinirSenha(Request $request)
    {
        // Validação do token e da nova senha
        $request->validate([
            'token' => 'required|string',
            'senha' => 'required|string|min:6',
        ]);

        // Busca o token na tabela 'password_resets'
        $reset = PasswordReset::where('token', $request->token)->first();

        // Verifica se o token existe
        if (!$reset) {
            return response()->json(['error' => 'Token inválido ou expirado'], 400);
        }

        // Verifica se o token expirou (tempo de expiração: 2 horas)
        $tokenCreationTime = Carbon::parse($reset->created_at);
        if (Carbon::now()->diffInHours($tokenCreationTime) > 2) {
            return response()->json(['error' => 'Token expirado. Solicite uma nova redefinição de senha.'], 400);
        }

        // Busca o usuário pelo e-mail associado ao token
        $user = User::where('email', $reset->email)->first();

        // Verifica se o usuário existe
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado.'], 404);
        }

        // Atualiza a senha do usuário
        $user->senha = Hash::make($request->senha);
        $user->save();

        // Apaga o token da tabela 'password_resets' com base no token, não no id
        PasswordReset::where('token', $request->token)->delete();

        return response()->json(['message' => 'Senha redefinida com sucesso.']);
    }

    public function login(Request $request)
    {
        $dados = $request->except('_token');

        // Buscar o usuário pelo CPF
        $user = User::where('cpf', $dados['cpf'])->first();

        if ($user && Hash::check($dados['senha'], $user->senha)) {
            // Senha válida, login bem-sucedido
            return response()->json(['message' => 'Login bem sucedido', 'user' => $user], 200);
        } else {
            // Usuário não encontrado ou senha inválida
            return response()->json(['message' => 'CPF ou senha inválidos'], 401);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $dados = $request->except('_token');

            // Validação do CPF
            $cpfLength = strlen($dados['cpf']);
            if ($cpfLength !== 11) {
                return response()->json(['error' => 'CPF deve ter 11 caracteres', 'sucesso' => 99], 200);
            }

            // Validação do email
            if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
                return response()->json(['error' => 'Email inválido', 'sucesso' => 98], 200);
            }

            // Criptografar a senha antes de armazenar
            $dados['senha'] = bcrypt($dados['senha']);

            // Cadastrar o usuário no banco de dados
            $user = User::create($dados);
            return response()->json($user, 201);

        } catch (\Illuminate\Database\QueryException $e) {
            // Verificar se a exceção é devido a chave única violada (CPF ou email duplicado)
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                if (strpos($e->getMessage(), 'cpf') !== false) {
                    return response()->json(['error' => 'CPF já cadastrado'], 400);
                } elseif (strpos($e->getMessage(), 'email') !== false) {
                    return response()->json(['error' => 'Email já cadastrado'], 400);
                }
            } else {
                return response()->json(['error' => 'Erro de banco de dados'], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string',
            'email' => 'required|string|email|max:255',
            // Adicione as outras regras conforme necessário para os campos que você está atualizando
        ]);

        // Validação do CPF
        $cpfLength = strlen($request->input('cpf'));
        if ($cpfLength !== 11) {
            return response()->json(['error' => 'CPF deve ter 11 caracteres', 'sucesso' => 99], 200);
        }

        // Validação do email
        if (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
            return response()->json(['error' => 'Email inválido', 'sucesso' => 98], 200);
        }

        try {
            // Encontrar o usuário pelo ID
            $user = User::findOrFail($id);

            // Atualizar os dados do usuário
            $user->update([
                'nome' => $request->input('nome'),
                'cpf' => $request->input('cpf'),
                'idade' => $request->input('idade'),
                'email' => $request->input('email'),  // Incluí o campo email
                // Adicione os outros campos que você precisa atualizar
            ]);

            // Retornar uma resposta de sucesso
            return response()->json(['message' => 'Usuário atualizado com sucesso', 'sucesso' => true], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado', 'sucesso' => false], 200);
        } catch (\Exception $e) {
            // Outros erros
            return response()->json(['message' => 'Erro ao atualizar usuário', 'sucesso' => 98, 'erro' => $e->getMessage()], 200);
        }

        // Retornar uma resposta de sucesso ou a representação atualizada do usuário
        return response()->json($user, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            // Deletar o user
            $user->delete();
            // Retornar uma resposta de sucesso
            return response()->json(['message' => 'Usuario deletado com sucesso', 'sucesso' => true], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // user não encontrado
            return response()->json(['message' => 'Usuario não encontrado', 'sucesso' => false], 200);
        } catch (\Exception $e) {
            // Outros erros
            return response()->json(['message' => 'Erro ao deletar Usuario', 'sucesso' => false, 'erro' => $e->getMessage()], 500);
        }
    }
}
