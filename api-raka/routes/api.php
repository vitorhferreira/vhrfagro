<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VacinaController;
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


// vacinas
Route::get('/vacinas', [VacinaController::class, 'index']);
Route::post('/cadvacinas', [VacinaController::class, 'store'])->name('vacina.store');
Route::delete('/vacinas/{id}', [VacinaController::class, 'destroy']);
Route::put('/vacinas/{id}', [VacinaController::class, 'update']);

// medicos
Route::get('/medico', [MedicoController::class, 'index']);
Route::post('/cadmedico', [MedicoController::class, 'store'])->name('medico.store');
Route::put('/medico/{id}', [MedicoController::class, 'update']);
Route::delete('/medico/{id}', [MedicoController::class, 'destroy']);


// pacientes e login
Route::get('/pacientes', [PacienteController::class, 'index']);
Route::post('/cadpacientes', [PacienteController::class, 'store'])->name('paciente.store');
Route::delete('/pacientes/{id}', [PacienteController::class, 'destroy']);
Route::put('/pacientes/{id}', [PacienteController::class, 'update']);

// Route::post('/login', [PacienteController::class, 'login'])->name('login.login');


// agendamentos
Route::get('/agendamentos', [AgendamentoController::class, 'index']);
Route::post('/cadagendamentos', [AgendamentoController::class, 'store'])->name('agendamento.store');
Route::delete('/agendamentos/{id}', [AgendamentoController::class, 'destroy']);
Route::put('/agendamentos/{id}', [AgendamentoController::class, 'update']);

// usuario
Route::get('/user', [UsuarioController::class, 'index']);
Route::post('/caduser', [UsuarioController::class, 'store'])->name('user.store');
Route::delete('/user/{id}', [UsuarioController::class, 'destroy']);
Route::put('/user/{id}', [UsuarioController::class, 'update']);

Route::post('/login', [UsuarioController::class, 'login'])->name('login.login');

//  php artisan config:cache
// php artisan route:cache
