<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medico = Agendamento::get();
        return response()->json($medico);
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
        $agendamento = Agendamento::create($dados);
        // dd($agendamemto);
        return response()->json($agendamento, 200);
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
            'medico' => 'required|string|max:255',
            'cpf' => 'required|string|max:11',
            // Adicione as outras regras conforme necessário para os campos que você está atualizando
        ]);

        // Encontrar o paciente pelo ID
        $agendamento = Agendamento::findOrFail($id);

        // Atualizar os dados do agendamento com base nos dados recebidos na requisição
        $agendamento->update([
            'cpf' => $request->input('cpf'),
            'medico' =>$request->input('medico'),
            'data' =>$request->input('data'),
            'telefone' =>$request->input('telefone'),
            'hora' =>$request->input('hora'),
            'local' =>$request->input('local'),
            // Adicione os outros campos que você precisa atualizar
        ]);

        // Retornar uma resposta de sucesso ou a representação atualizada do agendamento
        return response()->json($agendamento, 200);
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
            $agendamento = Agendamento::findOrFail($id);
            // Deletar o Agendamento
            $agendamento->delete();
            // Retornar uma resposta de sucesso
            return response()->json(['message' => 'Agendamento deletado com sucesso', 'sucesso' => true], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Agendamento não encontrado
            return response()->json(['message' => 'Agendamento não encontrado', 'sucesso' => false], 200);
        } catch (\Exception $e) {
            // Outros erros
            return response()->json(['message' => 'Erro ao deletar Agendamento', 'sucesso' => false, 'erro' => $e->getMessage()], 500);
        }
    }
}
