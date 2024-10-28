<?php

use App\Http\Controllers\ConsumoRacaoController;
use App\Http\Controllers\vacinaController;
use App\Http\Controllers\loteController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VendasController;
use App\Http\Controllers\gastovetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndividualController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Rotas para relatorio
Route::get('/relatorio', [RelatorioController::class, 'index']);
Route::get('/relatorio/{lote_id}', [RelatorioController::class, 'show']);
Route::post('/relatorio', [RelatorioController::class, 'store'])->name('relatorio.store');
Route::delete('/relatorio/{id}', [RelatorioController::class, 'destroy']);
Route::put('/relatorio/{id}', [RelatorioController::class, 'update']);

Route::get('/vendas', [VendasController::class, 'index']);
Route::get('/vendas/{id}', [VendasController::class, 'show']);
Route::post('/vendas', [VendasController::class, 'store']);
Route::put('/vendas/{id}', [VendasController::class, 'update']);
Route::delete('/vendas/{id}', [VendasController::class, 'destroy']);
Route::get('/vendas/{id}/lucro', [VendasController::class, 'calcularLucro']);
Route::put('/vendas/{id}/recebido', [VendasController::class, 'marcarComoRecebido'])->name('gastovets.marcarComoRecebido');
Route::put('/vendas/{id}/naorecebido', [VendasController::class, 'marcarComoNaoRecebido']);

// gastovets
Route::get('/gastovets', [GastovetController::class, 'index']);
Route::get('/gastovets/{id}', [GastovetController::class, 'index1']);/*rota do android*/
Route::post('/cadgastovets', [GastovetController::class, 'store'])->name('gastovets.store');
Route::delete('/gastovets/{id}', [GastovetController::class, 'destroy']);
Route::put('/gastovets/{id}', [GastovetController::class, 'update']);
Route::put('/gastovets/{id}/pago', [GastovetController::class, 'marcarComoPago'])->name('gastovets.marcarComoPago');
Route::put('/gastovets/{id}/naopago', [GastovetController::class, 'marcarComoNaoPago']);

Route::delete('/limpar-tokens-expirados', [UsuarioController::class, 'limparTokensExpirados']);

// lotes
Route::get('/lote', [LoteController::class, 'index']);
Route::post('/cadlote', [LoteController::class, 'store'])->name('lote.store');
Route::post('/lote/{id}', [LoteController::class, 'update']);
Route::delete('/lote/{id}', [LoteController::class, 'destroy']);
Route::put('/lotes/{id}/quantidade', [LoteController::class, 'update2']);
Route::put('/lotes/{id}/restore-quantidade', [LoteController::class, 'restoreQuantidade']);


//controle individual
Route::get('/animal', [IndividualController::class, 'index']);
Route::get('/animal/{numero_identificacao}', [IndividualController::class, 'show']);
Route::get('/animal/historico/{numero_identificacao}', [IndividualController::class, 'historicoPeso']);
Route::post('/animal', [IndividualController::class, 'store']);
Route::put('/animal/{numero_identificacao}', [IndividualController::class, 'update']);
Route::get('/animal/ultimos-registros', [IndividualController::class, 'ultimosRegistros']);
Route::delete('/animal/{id}', [IndividualController::class, 'destroy']);


// pacientes e login
Route::get('/consumo_racao', [ConsumoRacaoController::class, 'index']);
Route::post('/cadconsumo_racao', [ConsumoRacaoController::class, 'store'])->name('consumoracao.store');
Route::delete('/consumo_racao/{id}', [ConsumoRacaoController::class, 'destroy']);
Route::put('/consumo_racao/{id}', [ConsumoRacaoController::class, 'update']);


// Route::post('/login', [PacienteController::class, 'login'])->name('login.login');


// vacinas
Route::get('/vacinas', [VacinaController::class, 'index']);
Route::post('/cadvacinas', [VacinaController::class, 'store'])->name('vacina.store');
Route::delete('/vacinas/{id}', [VacinaController::class, 'destroy']);
Route::put('/vacinas/{id}', [VacinaController::class, 'update']);
Route::get('/vacinas/{cpf}', [VacinaController::class, 'index2']); /*rota do android*/

// Rotas para Relatórios
Route::get('/relatorios', [RelatorioController::class, 'index']); // Listar todas as vendas
Route::get('/relatorios/{id}', [RelatorioController::class, 'show']); // Exibir uma venda específica por ID
Route::post('/relatorios', [RelatorioController::class, 'store'])->name('relatorios.store'); // Criar uma nova venda e atualizar o relatório
Route::put('/relatorios/{id}', [RelatorioController::class, 'update']); // Atualizar uma venda existente e o relatório
Route::delete('/relatorios/{id}', [RelatorioController::class, 'destroy']); // Remover uma venda e atualizar o relatório
Route::get('/relatorios/lucro/{vendaId}', [RelatorioController::class, 'calcularLucro']); // Calcular o lucro de uma venda específica

// usuario
Route::get('/verificar-usuario', [UsuarioController::class, 'verificarUsuario']);
Route::get('/user', [UsuarioController::class, 'index']);
Route::post('/caduser', [UsuarioController::class, 'store'])->name('user.store');
Route::delete('/user/{id}', [UsuarioController::class, 'destroy']);
Route::put('/user/{id}', [UsuarioController::class, 'update']);
Route::post('/verificarUsuario', [UsuarioController::class, 'verificarUsuario']);

Route::post('/login', [UsuarioController::class, 'login'])->name('login.login');

//email
Route::post('/solicitar-redefinicao-senha', [UsuarioController::class, 'solicitarRedefinicaoSenha']);
Route::post('/redefinir-senha', [UsuarioController::class, 'redefinirSenha']);


//  php artisan config:cache
// php artisan route:cache
