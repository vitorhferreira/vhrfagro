<?php

namespace App\Http\Controllers;


use App\Models\Pacientes;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vacinas = Pacientes::get();
        return response()->json($vacinas);
    }

    public function login(Request $request)
    {

        $dados = $request->except('_token');

        $paciente = Pacientes::where('cpf', $dados['cpf'])
            ->where('senha', $dados['senha'])
            ->first();

        if ($paciente) {
            // Paciente encontrado, faça o que for necessário (ex: autenticação)
            // Exemplo: Autenticar o usuário, redirecionar, etc.
            return response()->json(['message' => 'Login bem sucedido', 'paciente' => $paciente], 200);
        } else {
            // Paciente não encontrado
            return response()->json(['message' => 'CPF ou senha inválidos'], 401);
        }
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
        $pacientes = Pacientes::create($dados);
        return response()->json($pacientes, 201);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
