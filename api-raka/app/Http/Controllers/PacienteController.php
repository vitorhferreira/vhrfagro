<?php

namespace App\Http\Controllers;


use App\Models\Pacientes;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paciente = Pacientes::get();
        return response()->json($paciente);
    }

    public function login(Request $request)
    {

        $dados = $request->except('_token');

        $paciente = Pacientes::where('cpf', $dados['cpf'])
            ->where('senha', $dados['senha'])
            ->first();

        if ($paciente) {
            // Paciente encontrado, faça o que for necessário (ex: autenticação)
            // Exemplo: Autenticar o usuário, redirecionar, etc.
            return response()->json(['message' => 'Login bem sucedido', 'paciente' => $paciente], 200);
        } else {
            // Paciente não encontrado
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
    public function store(Request $request){

    try {
        $dados = $request->except('_token');
         $cpfLength = strlen($dados['cpf']);
            if ($cpfLength !== 11) {
                return response()->json(['error' => 'CPF deve ter 11 caracteres', 'sucesso' => 99], 200);
            }
        $pacientes = Pacientes::create($dados);
        return response()->json($pacientes, 201);
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
            'idade' => 'required|integer',
            // Adicione as outras regras conforme necessário para os campos que você está atualizando
        ]);

        // Encontrar o paciente pelo ID
        $paciente = Pacientes::findOrFail($id);

        // Atualizar os dados do paciente com base nos dados recebidos na requisição
        $paciente->update([
            'nome' => $request->input('nome'),
            'cpf' =>$request->input('cpf'),
            'idade' => $request->input('idade'),
            // Adicione os outros campos que você precisa atualizar
        ]);

        // Retornar uma resposta de sucesso ou a representação atualizada do paciente
        return response()->json($paciente, 200);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /**
     * Remove um usuário específico.
     */
    public function destroy($id)
    {
        try {
            $paciente = Pacientes::findOrFail($id);
            // Deletar o paciente
            $paciente->delete();
            // Retornar uma resposta de sucesso
            return response()->json(['message' => 'Paciente deletado com sucesso', 'sucesso' => true], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Paciente não encontrado
            return response()->json(['message' => 'Paciente não encontrado', 'sucesso' => false], 200);
        } catch (\Exception $e) {
            // Outros erros
            return response()->json(['message' => 'Erro ao deletar paciente', 'sucesso' => false, 'erro' => $e->getMessage()], 500);
        }
    }
}
