<?php

namespace App\Http\Controllers;

use App\Models\Individual;
use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndividualController extends Controller
{
        // Listar todos os animais
        public function index()
        {
            $animais = Individual::all();
            return response()->json($animais, 200);
        }

        public function show($numero_identificacao)
        {
            $animal = Individual::where('numero_identificacao', $numero_identificacao)->orderBy('data', 'desc')->first();

            if ($animal) {
                return response()->json($animal, 200);
            } else {
                return response()->json(['error' => 'Animal não encontrado'], 404);
            }
        }

    // Histórico de peso do animal
    public function historicoPeso($numero_identificacao)
    {
        $historico = Individual::where('numero_identificacao', $numero_identificacao)
            ->orderBy('data', 'asc')
            ->get(['peso', 'data']);

        return response()->json($historico, 200);
    }

    // Cadastrar um novo animal
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'numero_identificacao' => 'required|string|max:255',
            'id_lote' => 'required|exists:lotes,id',
            'numero_lote' => 'required|string|max:255',
            'peso' => 'required|numeric',
            'data' => 'required|date',
            'anotacoes' => 'nullable|string',
        ]);

        $lote = Lote::find($validatedData['id_lote']);
        if ($lote->quantidade <= Individual::where('id_lote', $lote->id)->count()) {
            return response()->json(['error' => 'Quantidade de animais no lote excedida'], 400);
        }

        $animal = Individual::create($validatedData);
        return response()->json($animal, 201);
    }

        // Excluir um animal existente
    public function destroy($numero_identificacao)
    {
        $animal = Individual::where('id', $numero_identificacao)->first();

        if (!$animal) {
            return response()->json(['error' => 'Animal não encontrado'], 404);
        }

        // Realiza a exclusão
        $animal->delete();

        return response()->json(['message' => 'Animal excluído com sucesso'], 200);
    }

  /*  public function ultimosRegistros()
    {
        // Subquery para obter o último registro de cada animal baseado na data mais recente
        $animais = Individual::select('numero_identificacao', 'numero_lote', 'peso', 'data', 'anotacoes')
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                      ->from('individual')
                      ->groupBy('numero_identificacao');
            })
            ->orderBy('data', 'desc')
            ->get();

        // Verificar se há animais retornados
        if ($animais->isEmpty()) {
            return response()->json(['error' => 'Nenhum animal encontrado'], 404);
        }

        // Retornar os dados como JSON
        return response()->json($animais, 200);
    }*/

    // Atualizar dados de um animal existente
    public function update(Request $request, $numero_identificacao)
    {
        $validatedData = $request->validate([
            'numero_lote' => 'required|string|max:255',
            'peso' => 'required|numeric',
            'data' => 'required|date',
            'anotacoes' => 'nullable|string',
        ]);

        $animal = Individual::where('numero_identificacao', $numero_identificacao)->first();

        if (!$animal) {
            return response()->json(['error' => 'Animal não encontrado'], 404);
        }

        // Cria um novo registro para manter o histórico
        $animalAtualizado = Individual::create([
            'numero_identificacao' => $numero_identificacao,
            'id_lote' => $animal->id_lote,
            'numero_lote' => $validatedData['numero_lote'],
            'peso' => $validatedData['peso'],
            'data' => $validatedData['data'],
            'anotacoes' => $validatedData['anotacoes'],
        ]);

        return response()->json($animalAtualizado, 200);
    }
}
