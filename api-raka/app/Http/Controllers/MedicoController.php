<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medico = Medico::get();
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
            $cpfLength = strlen($dados['cpf']);
            if ($cpfLength !== 11) {
                return response()->json(['error' => 'CPF deve ter 11 caracteres', 'sucesso' => 99], 200);
            }
            $medico = Medico::create($dados);
            // dd($medico);
           
            return response()->json($medico, 200);
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
            'cpf' => 'required|string',
        ]);

        // Encontrar o medico pelo ID
        $medico = Medico::findOrFail($id);
        // Atualizar os dados do paciente com base nos dados recebidos na requisição
        $medico->update([
            'nome' => $request->input('nome'),
            'cpf' =>$request->input('cpf'),
            'idade' => $request->input('idade'),
            'profissao' => $request->input('profissao'),
            // Adicione os outros campos que você precisa atualizar
        ]);

        // Retornar uma resposta de sucesso ou a representação atualizada do paciente
        return response()->json($medico, 200);
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
            $medico = Medico::findOrFail($id);
            // Deletar o medico
            $medico->delete();
            // Retornar uma resposta de sucesso
            return response()->json(['message' => 'medico deletado com sucesso', 'sucesso' => true], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // medico não encontrado
            return response()->json(['message' => 'medico não encontrado', 'sucesso' => false], 200);
        } catch (\Exception $e) {
            // Outros erros
            return response()->json(['message' => 'Erro ao deletar medico', 'sucesso' => false, 'erro' => $e->getMessage()], 500);
        }
    }
}
