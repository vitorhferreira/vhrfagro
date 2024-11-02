<?php

namespace App\Http\Controllers;

use App\Models\Vacina;
use Illuminate\Http\Request;

class vacinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medico = vacina::get();
        return response()->json($medico);
    }

    public function index2($cpf)/*index do android*/
    {
        // Busca os vacinas associados ao CPF
        $vacinas = vacina::where('numero_lote', $cpf)->get();

        // Verifica se foram encontrados vacinas
        if ($vacinas->isEmpty()) {
            return response()->json(['error' => 'Nenhuma vacina encontrada'], 404);
        }

        // Retorna a lista de vacinas como resposta JSON
        return response()->json($vacinas);
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
        // Exclui o token CSRF e armazena todos os outros dados da requisição
        $dados = $request->except('_token');

        // Verifica o conteúdo dos dados recebidos para garantir que `numero_identificacao` esteja presente
        if (!array_key_exists('numero_identificacao', $dados)) {
            return response()->json(['error' => 'Campo numero_identificacao é obrigatório.'], 400);
        }

        // Exibe os dados recebidos para verificar se estão corretos (opcional para depuração)
        // dd($dados);

        try {
            // Cria o registro no banco de dados
            $vacina = vacina::create($dados);

            // Retorna a resposta com o registro criado
            return response()->json($vacina, 200);

        } catch (\Exception $e) {
            // Retorna uma mensagem de erro se houver uma exceção
            return response()->json(['error' => 'Erro ao salvar a vacina: ' . $e->getMessage()], 500);
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

        ]);

        // Encontrar o lote pelo ID
        $vacina = Vacina::findOrFail($id);
        // Atualizar os dados do paciente com base nos dados recebidos na requisição
        $vacina->update([
            'nome_vacina' => $request->input('nome_vacina'),
            'data_aplicacao' =>$request->input('data_aplicacao'),
            'numero_lote' =>$request->input('numero_lote'),
            'quantidade_cabecas' =>$request->input('quantidade_cabecas'),
            'numero_identificacao' =>$request->input('numero_identificacao'),
            // Adicione os outros campos que você precisa atualizar
        ]);

        // Retornar uma resposta de sucesso ou a representação atualizada do paciente
        return response()->json($vacina, 200);
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
            $vacina = vacina::findOrFail($id);
            // Deletar o vacina
            $vacina->delete();
            // Retornar uma resposta de sucesso
            return response()->json(['message' => 'vacina deletada com sucesso', 'sucesso' => true], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // vacina não encontrado
            return response()->json(['message' => 'vacina não encontrada', 'sucesso' => false], 200);
        } catch (\Exception $e) {
            // Outros erros
            return response()->json(['message' => 'Erro ao deletar vacina', 'sucesso' => false, 'erro' => $e->getMessage()], 500);
        }
    }
}
