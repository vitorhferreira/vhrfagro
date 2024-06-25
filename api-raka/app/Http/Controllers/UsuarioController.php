<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::get();
        return response()->json($user);
    }
    public function login(Request $request)
    {

        $dados = $request->except('_token');

        $user = User::where('cpf', $dados['cpf'])
            ->where('senha', $dados['senha'])
            ->first();

        if ($user) {
            // Usuario encontrado, faça o que for necessário (ex: autenticação)
            // Exemplo: Autenticar o usuário, redirecionar, etc.
            return response()->json(['message' => 'Login bem sucedido', 'user' => $user], 200);
        } else {
            // user não encontrado
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

            $cpfLength = strlen($dados['cpf']);
            if ($cpfLength !== 11) {
                return response()->json(['error' => 'CPF deve ter 11 caracteres', 'sucesso' => 99], 200);
            }
            $user = User::create($dados);
            return response()->json($user, 201);
        } catch (\Illuminate\Database\QueryException $e) {
            // Verificar se a exceção é devido a chave única violada (CPF duplicado)
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) { // Código de erro para chave única violada (pode variar dependendo do banco de dados)
                return response()->json(['error' => 'CPF já cadastrado'], 400);
            } else {
                // Outro tipo de erro de banco de dados
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
            // Aqui vão as regras de validação, por exemplo:
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|',
            // Adicione as outras regras conforme necessário para os campos que você está atualizando
        ]);


        $cpfLength = strlen($request->input('cpf'));
        if ($cpfLength !== 11) {
            return response()->json(['error' => 'CPF deve ter 11 caracteres', 'sucesso' => 99], 200);
        }

        // Encontrar o user pelo ID
      



        try {
            $user = User::findOrFail($id);
            
            $user->update([
                'nome' => $request->input('nome'),
                'cpf' => $request->input('cpf'),
                'idade' => $request->input('idade'),
                // Adicione os outros campos que você precisa atualizar
            ]);
            // Retornar uma resposta de sucesso
            return response()->json(['message' => 'Usuario deletado com sucesso', 'sucesso' => true], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        
            return response()->json(['message' => 'Usuario não encontrado', 'sucesso' => false], 200);
        } catch (\Exception $e) {
            // Outros erros
            return response()->json(['message' => 'Erro ao atualizar Usuario', 'sucesso' => 98, 'erro' => $e->getMessage()], 200);
        }

        // Retornar uma resposta de sucesso ou a representação atualizada do user
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
