<?php

namespace App\Http\Controllers;

use App\Models\ConsumoRacao;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ConsumoRacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consumoRacao = ConsumoRacao::get();
        return response()->json($consumoRacao);
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

            // Validação do CPF (se necessário, por exemplo, no caso do lote ou outro campo)
            // Exemplo: Validação de quantidade ou outros dados
            if (strlen($dados['tipo_racao']) < 3) {
                return response()->json(['error' => 'O tipo de ração deve ter pelo menos 3 caracteres', 'sucesso' => 99], 200);
            }

            $consumoRacao = ConsumoRacao::create($dados);
            return response()->json($consumoRacao, 201);
        } catch (\Illuminate\Database\QueryException $e) {
            // Verificar se a exceção é devido a uma chave única violada
            return response()->json(['error' => 'Erro de banco de dados', 'erro' => $e->getMessage()], 500);
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
        try {
            $consumoRacao = ConsumoRacao::findOrFail($id);
            return response()->json($consumoRacao, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Consumo de ração não encontrado'], 404);
        }
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

        ]);

        // Encontrar o lote pelo ID
        $consumoRacao = ConsumoRacao::findOrFail($id);
        // Atualizar os dados do paciente com base nos dados recebidos na requisição
        $consumoRacao->update([
            'tipo_racao' => $request->input('tipo_racao'),
            'quantidade_kg' =>$request->input('quantidade_kg'),
            'valor_estimado' =>$request->input('valor_estimado'),
            'data_inicial' =>$request->input('data_inicial'),
            'data_final' =>$request->input('data_final'),
            // Adicione os outros campos que você precisa atualizar
        ]);

        // Retornar uma resposta de sucesso ou a representação atualizada do paciente
        return response()->json($consumoRacao, 200);
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
            $consumoRacao = ConsumoRacao::findOrFail($id);
            $consumoRacao->delete();
            return response()->json(['message' => 'Consumo de ração deletado com sucesso', 'sucesso' => true], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Consumo de ração não encontrado', 'sucesso' => false], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar consumo de ração', 'erro' => $e->getMessage()], 500);
        }
    }
}
