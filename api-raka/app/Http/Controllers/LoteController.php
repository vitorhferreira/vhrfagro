<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lote = Lote::get();
        return response()->json($lote);
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


    // Função para cadastrar novo lote
    public function store(Request $request)
    {
        // Valida os dados, incluindo o arquivo (não obrigatório)
        $request->validate([
            'quantidade' => 'required|integer|min:1',
            'peso' => 'required|numeric|min:1',
            'valor_individual' => 'required|numeric|min:1',
            'idade_media' => 'required|integer|min:1',
            'data_compra' => 'required|date',
            'data_pagamento' => 'required|date',
            'numero_lote' => 'required|integer|unique:lotes,numero_lote',
            'documento' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Documento opcional
        ]);

        // Cria um novo lote
        $lote = new Lote();
        $lote->quantidade = $request->quantidade;
        $lote->peso = $request->peso;
        $lote->valor_individual = $request->valor_individual;
        $lote->idade_media = $request->idade_media;
        $lote->data_compra = $request->data_compra;
        $lote->numero_lote = $request->numero_lote;
        $lote->data_pagamento = $request->data_pagamento;

        // Verifica se foi enviado um arquivo de documento
        if ($request->hasFile('documento')) {
            // Armazena o arquivo na pasta 'documentos_lotes' dentro de 'public'
            $documentoPath = $request->file('documento')->store('documentos_lotes', 'public');
            // Salva o caminho do documento no lote
            $lote->documento = $documentoPath;
        }

        // Salva o lote no banco de dados
        $lote->save();

        return response()->json(['message' => 'Lote cadastrado com sucesso', 'sucesso' => true], 201);
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

     public function restoreQuantidade(Request $request, $id)
        {
            // Validar a entrada
            $validatedData = $request->validate([
                'quantidade' => 'required|integer|min:1',
            ]);

            // Buscar o lote
            $lote = Lote::find($id);
            if (!$lote) {
                return response()->json(['error' => 'Lote não encontrado'], 404);
            }

            // Restaurar a quantidade do lote
            $lote->quantidade += $validatedData['quantidade'];
            $lote->save();

            return response()->json(['message' => 'Quantidade restaurada com sucesso no lote'], 200);
        }


     public function update2(Request $request, $id)
     {
         // Validar a entrada
         $validatedData = $request->validate([
             'quantidade' => 'required|integer|min:0',
         ]);

         // Buscar o lote
         $lote = Lote::find($id);
         if (!$lote) {
             return response()->json(['error' => 'Lote não encontrado'], 404);
         }

         // Atualizar a quantidade
         $lote->quantidade = $validatedData['quantidade'];

         // Verifica se o lote chegou a zero e pode ser inativado ou excluído
         /*if ($lote->quantidade === 0) {
             $lote->status = 'inativo'; // Caso tenha uma coluna 'status'
         }*/

         $lote->save();

         return response()->json(['message' => 'Lote atualizado com sucesso'], 200);
     }

     public function marcarComoPago($id)
     {
         try {
             $gasto = Lote::findOrFail($id);
             $gasto->pago = true; // Marca o gasto como pago
             $gasto->save();

             return response()->json(['message' => 'Lote marcado como pago com sucesso', 'sucesso' => true], 200);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             return response()->json(['message' => 'Lote não encontrado', 'sucesso' => false], 404);
         } catch (\Exception $e) {
             return response()->json(['message' => 'Erro ao marcar lote como pago', 'sucesso' => false, 'erro' => $e->getMessage()], 500);
         }
     }

     public function marcarComoNaoPago($id)
        {
            try {
                $gasto = Lote::findOrFail($id);
                $gasto->pago = false; // Marca o gasto como não pago
                $gasto->save();

                return response()->json(['message' => 'Lote marcado como não pago com sucesso', 'sucesso' => true], 200);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['message' => 'Lote não encontrado', 'sucesso' => false], 404);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Erro ao marcar lote como não pago', 'sucesso' => false, 'erro' => $e->getMessage()], 500);
            }
        }

// Função para atualizar lote existente
public function update(Request $request, $id)
{
    $request->validate([
        // Aqui vão as regras de validação, por exemplo:

    ]);

    // Encontrar o lote pelo ID
    $lote = Lote::findOrFail($id);
    // Atualizar os dados do paciente com base nos dados recebidos na requisição
    $lote->update([
        'quantidade' => $request->input('quantidade'),
        'peso' =>$request->input('peso'),
        'valor_individual' => $request->input('valor_individual'),
        'idade_media' => $request->input('idade_media'),
        'data_compra' => $request->input('data_compra'),
        'data_pagamento' => $request->input('data_pagamento'),
        'numero_lote' => $request->input('numero_lote'),

    ]);
        // Verifica se foi enviado um novo arquivo de documento
        if ($request->hasFile('documento')) {
            // Excluir o documento anterior, se existir
            if ($lote->documento) {
                Storage::disk('public')->delete($lote->documento);
            }
            // Salva o novo documento
            $documentoPath = $request->file('documento')->store('documentos_lotes', 'public');
            $lote->documento = $documentoPath; // Atualiza o caminho do documento
        }



    // Atualiza o lote no banco de dados
    $lote->save();

    return response()->json(['message' => 'Lote atualizado com sucesso', 'sucesso' => true], 200);
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
            $lote = Lote::findOrFail($id);
            // Deletar olote
            $lote->delete();
            // Retornar uma resposta de sucesso
            return response()->json(['message' => 'lote deletado com sucesso', 'sucesso' => true], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // lote não encontrado
            return response()->json(['message' => 'lote não encontrado', 'sucesso' => false], 200);
        } catch (\Exception $e) {
            // Outros erros
            return response()->json(['message' => 'Erro ao deletar lote', 'sucesso' => false, 'erro' => $e->getMessage()], 500);
        }
    }
}


