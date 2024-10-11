<?php

namespace App\Http\Controllers;

use App\Models\Relatorio; // Importando o modelo Relatorio
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    /**
     * Exibe uma lista de todos os relatórios.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Buscar todos os relatórios
        $relatorios = Relatorio::all();

        // Retornar a lista de relatórios como resposta JSON
        return response()->json($relatorios, 200);
    }

    /**
     * Exibe um relatório específico por ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Buscar o relatório pelo ID
        $relatorio = Relatorio::find($id);

        if (!$relatorio) {
            return response()->json(['error' => 'Relatório não encontrado'], 404);
        }

        // Retornar o relatório encontrado como resposta JSON
        return response()->json($relatorio, 200);
    }

    /**
     * Armazena um novo relatório.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validação dos dados da requisição
        $validatedData = $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'valor_compra' => 'required|numeric',
            'peso_comprado' => 'required|numeric',
            'quantidade_comprada' => 'required|integer',
            'valor_venda' => 'required|numeric',
            'peso_vendido' => 'required|numeric',
            'quantidade_vendida' => 'required|integer',
            'total_gastos' => 'required|numeric',
            'total_vacinas' => 'required|integer',
            'lucro' => 'required|numeric',
            'numero_lote' => 'required|string|max:50',
        ]);

        // Criar um novo relatório com os dados validados
        $relatorio = Relatorio::create($validatedData);

        // Retornar o relatório criado como resposta JSON
        return response()->json($relatorio, 201);
    }

    /**
     * Atualiza um relatório existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Buscar o relatório pelo ID
        $relatorio = Relatorio::find($id);

        if (!$relatorio) {
            return response()->json(['error' => 'Relatório não encontrado'], 404);
        }

        // Validação dos dados da requisição
        $validatedData = $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'valor_compra' => 'required|numeric',
            'peso_comprado' => 'required|numeric',
            'quantidade_comprada' => 'required|integer',
            'valor_venda' => 'required|numeric',
            'peso_vendido' => 'required|numeric',
            'quantidade_vendida' => 'required|integer',
            'total_gastos' => 'required|numeric',
            'total_vacinas' => 'required|integer',
            'lucro' => 'required|numeric',
            'numero_lote' => 'required|string|max:50',
        ]);

        // Atualizar o relatório com os dados validados
        $relatorio->update($validatedData);

        // Retornar o relatório atualizado como resposta JSON
        return response()->json($relatorio, 200);
    }

    /**
     * Remove um relatório.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Buscar o relatório pelo ID
        $relatorio = Relatorio::find($id);

        if (!$relatorio) {
            return response()->json(['error' => 'Relatório não encontrado'], 404);
        }

        // Deletar o relatório
        $relatorio->delete();

        // Retornar uma resposta de sucesso
        return response()->json(['message' => 'Relatório deletado com sucesso'], 200);
    }
}
