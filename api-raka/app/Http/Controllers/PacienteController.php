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
        echo 'aki';
        die;
        // Validação dos dados de entrada
        $request->validate([
            'cpf' => 'required|string|max:11',
            'senha' => 'required|string|min:6',
        ]);

        // Tentar encontrar o usuário pelo CPF
        $user = Pacientes::where('cpf', $request->cpf)->first();

        // Verificar se o usuário existe e se a senha está correta
        // if ($user && Hash::check($request->password, $user->password)) {
        //     // Gerar um token de autenticação (exemplo usando Laravel Sanctum)
        //     $token = $user->createToken('authToken')->plainTextToken;

        //     return response()->json([
        //         'message' => 'Login successful',
        //         'token' => $token,
        //     ]);
        // }

        // Retornar uma resposta de erro se a autenticação falhar
        // throw ValidationException::withMessages([
        //     'cpf' => ['The provided credentials are incorrect.'],
        // ]);
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
