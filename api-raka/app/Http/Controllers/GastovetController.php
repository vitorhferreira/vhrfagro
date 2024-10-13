<?php

namespace App\Http\Controllers;

use App\Models\Gastovet;
use Illuminate\Http\Request;

class GastovetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo 'aki';
        // die;
        $gastovets = Gastovet::get();
        return response()->json($gastovets);
    }

    public function index1($motivo_gasto)/*index do android*/
    {
        // Busca as gastovets associadas ao motivo_gasto
        $gastovets = Gastovet::where('motivo_gasto', $motivo_gasto)->get();

        // Verifica se as gastovets foram encontradas
        if ($gastovets->isEmpty()) {
            return response()->json(['error' => 'Nenhum Gasto encontrada para este motivo_gasto'], 404);
        }

        // Retorna a lista de gastovets como resposta JSON
        return response()->json($gastovets);
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

     public function marcarComoPago($id)
     {
         try {
             $gasto = Gastovet::findOrFail($id);
             $gasto->pago = true; // Marca o gasto como pago
             $gasto->save();

             return response()->json(['message' => 'Gasto marcado como pago com sucesso', 'sucesso' => true], 200);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             return response()->json(['message' => 'Gasto não encontrado', 'sucesso' => false], 404);
         } catch (\Exception $e) {
             return response()->json(['message' => 'Erro ao marcar gasto como pago', 'sucesso' => false, 'erro' => $e->getMessage()], 500);
         }
     }

     public function marcarComoNaoPago($id)
        {
            try {
                $gasto = Gastovet::findOrFail($id);
                $gasto->pago = false; // Marca o gasto como não pago
                $gasto->save();

                return response()->json(['message' => 'Gasto marcado como não pago com sucesso', 'sucesso' => true], 200);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['message' => 'Gasto não encontrado', 'sucesso' => false], 404);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Erro ao marcar gasto como não pago', 'sucesso' => false, 'erro' => $e->getMessage()], 500);
            }
        }

    public function store(Request $request)
    {
        {
            $dados = $request->except('_token');

            $gastovet = Gastovet::create($dados);
            // dd($lote);

            return response()->json($gastovet, 200);
    }


        // Cria uma nova gastovet com os dados validados
        $gastovet = Gastovet::create($dados);

        // Retorna a gastovet recém-criada em formato JSON
        return response()->json($gastovet, 201);
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
        $validatedData = $request->validate([
            'motivo_gasto' => 'required|string',
            'qtd_cabecas' => 'required|integer',
            'data_pagamento' => 'required|date',
            'valor' => 'required|string',
            'lote' => 'required|string',
        ]);

        // Encontrar o paciente pelo ID
        $gastovet = Gastovet::findOrFail($id);

        // Atualizar os dados do paciente com base nos dados recebidos na requisição
        $gastovet->update([
            'motivo_gasto' => $request->input('motivo_gasto'),
            'qtd_cabecas' =>$request->input('qtd_cabecas'),
            'data_pagamento' => $request->input('data_pagamento'),
            'valor' => $request->input('valor'),
            'lote' => $request->input('lote'),
            // Adicione os outros campos que você precisa atualizar
        ]);

        // Retornar uma resposta de sucesso ou a representação atualizada do paciente
        return response()->json($gastovet, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $gastovet = gastovet::findOrFail($id);
        // // Deletar o paciente
        // $gastovet->delete();
        // Retornar uma resposta de sucesso
        // return response()->json(['message' => 'gastovet deletado com sucesso'], 200);


        try {
            $gastovet = Gastovet::findOrFail($id);
            $gastovet->delete();

            return response()->json(['message' => 'Gasto deletado com sucesso', 'sucesso' => true], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Gasto não encontrado', 'sucesso' => false], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar gasto', 'sucesso' => false, 'erro' => $e->getMessage()], 500);
        }
    }
}
