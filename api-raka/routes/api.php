<?php

use App\Http\Controllers\vacinaController;
use App\Http\Controllers\loteController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\gastovetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// gastovets
Route::get('/gastovets', [GastovetController::class, 'index']);
Route::get('/gastovets/{id}', [GastovetController::class, 'index1']);/*rota do android*/
Route::post('/cadgastovets', [GastovetController::class, 'store'])->name('gastovets.store');
Route::delete('/gastovets/{id}', [GastovetController::class, 'destroy']);
Route::put('/gastovets/{id}', [GastovetController::class, 'update']);

// lotes
Route::get('/lote', [LoteController::class, 'index']);
Route::post('/cadlote', [LoteController::class, 'store'])->name('lote.store');
Route::put('/lote/{id}', [LoteController::class, 'update']);
Route::delete('/lote/{id}', [LoteController::class, 'destroy']);


// pacientes e login
Route::get('/pacientes', [PacienteController::class, 'index']);
Route::post('/cadpacientes', [PacienteController::class, 'store'])->name('paciente.store');
Route::delete('/pacientes/{id}', [PacienteController::class, 'destroy']);
Route::put('/pacientes/{id}', [PacienteController::class, 'update']);
Route::post('/loginpacientes', [PacienteController::class, 'login'])->name('paciente.login');

// Route::post('/login', [PacienteController::class, 'login'])->name('login.login');


// vacinas
Route::get('/vacinas', [VacinaController::class, 'index']);
Route::post('/cadvacinas', [VacinaController::class, 'store'])->name('vacina.store');
Route::delete('/vacinas/{id}', [VacinaController::class, 'destroy']);
Route::put('/vacinas/{id}', [VacinaController::class, 'update']);
Route::get('/vacinas/{cpf}', [VacinaController::class, 'index2']); /*rota do android*/

// usuario
Route::get('/user', [UsuarioController::class, 'index']);
Route::post('/caduser', [UsuarioController::class, 'store'])->name('user.store');
Route::delete('/user/{id}', [UsuarioController::class, 'destroy']);
Route::put('/user/{id}', [UsuarioController::class, 'update']);

Route::post('/login', [UsuarioController::class, 'login'])->name('login.login');

//  php artisan config:cache
// php artisan route:cache
