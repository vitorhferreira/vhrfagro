<?php

namespace App\Http\Controllers;

use App\Models\Vendas;
use App\Models\Lote;
use App\Models\Gastovet;
use App\Models\Vacina;
use Illuminate\Http\Request;

class VendasController extends Controller
{
    /**
     * Exibe uma lista de todas as vendas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Buscar todas as vendas
        $vendas = Vendas::all();

        // Retornar a lista de vendas como resposta JSON
        return response()->json($vendas, 200);
    }

    /**
     * Exibe uma venda específica por ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Buscar a venda pelo ID
        $venda = Vendas::find($id);

        if (!$venda) {
            return response()->json(['error' => 'Venda não encontrada'], 404);
        }

        // Retornar a venda encontrada como resposta JSON
        return response()->json($venda, 200);
    }

    /**
     * Armazena uma nova venda.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validação dos dados da requisição
        $validatedData = $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'peso_medio_venda' => 'required|numeric',
            'comprador' => 'required|string|max:255',
            'cpf_cnpj_comprador' => 'required|string|max:18',
            'valor_unitario' => 'required|numeric',
            'quantidade_vendida' => 'required|integer',
            'prazo_pagamento' => 'nullable|string|max:50',
            'data_compra' => 'required|date',
        ]);

        // Criar uma nova venda com os dados validados
        $venda = Vendas::create($validatedData);

        // Retornar a venda criada como resposta JSON
        return response()->json($venda, 201);
    }

    /**
     * Atualiza uma venda existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Buscar a venda pelo ID
        $venda = Vendas::find($id);

        if (!$venda) {
            return response()->json(['error' => 'Venda não encontrada'], 404);
        }

        // Validação dos dados da requisição
        $validatedData = $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'peso_medio_venda' => 'required|numeric',
            'comprador' => 'required|string|max:255',
            'cpf_cnpj_comprador' => 'required|string|max:18',
            'valor_unitario' => 'required|numeric',
            'quantidade_vendida' => 'required|integer',
            'prazo_pagamento' => 'nullable|string|max:50',
            'data_compra' => 'required|date',
        ]);

        // Atualizar a venda com os dados validados
        $venda->update($validatedData);

        // Retornar a venda atualizada como resposta JSON
        return response()->json($venda, 200);
    }

    /**
     * Remove uma venda.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Buscar a venda pelo ID
        $venda = Vendas::find($id);

        if (!$venda) {
            return response()->json(['error' => 'Venda não encontrada'], 404);
        }

        // Deletar a venda
        $venda->delete();

        // Retornar uma resposta de sucesso
        return response()->json(['message' => 'Venda deletada com sucesso'], 200);
    }

    /**
     * Calcula o lucro de uma venda específica.
     *
     * @param  int  $vendaId
     * @return \Illuminate\Http\Response
     */
    public function calcularLucro($vendaId)
    {
        // Buscar a venda específica
        $venda = Vendas::find($vendaId);

        if (!$venda) {
            return response()->json(['error' => 'Venda não encontrada'], 404);
        }

        // Buscar o lote relacionado à venda
        $lote = Lote::find($venda->lote_id);

        if (!$lote) {
            return response()->json(['error' => 'Lote não encontrado'], 404);
        }

        // Buscar os gastos associados ao lote
        $gastos = Gastovet::where('lote', $lote->numero_lote)->get();
        $totalGastos = $gastos->sum('valor');

        // Calcular o lucro da venda
        $lucro = ($venda->valor_unitario * $venda->quantidade_vendida) - $totalGastos;

        // Retornar o lucro como resposta JSON
        return response()->json([
            'lote_id' => $lote->id,
            'numero_lote' => $lote->numero_lote,
            'quantidade_comprada' => $lote->quantidade,
            'peso_medio_venda' => $venda->peso_medio_venda,
            'valor_unitario' => $venda->valor_unitario,
            'quantidade_vendida' => $venda->quantidade_vendida,
            'total_gastos' => $totalGastos,
            'lucro' => $lucro,
        ], 200);
    }
}
