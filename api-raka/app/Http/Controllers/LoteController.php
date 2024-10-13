<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
            $dados = $request->except('_token');

            $lote = Lote::create($dados);
            // dd($lote);

            return response()->json($lote, 200);
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
            'numero_lote' => $request->input('numero_lote'),
            // Adicione os outros campos que você precisa atualizar
        ]);

        // Retornar uma resposta de sucesso ou a representação atualizada do paciente
        return response()->json($lote, 200);
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


