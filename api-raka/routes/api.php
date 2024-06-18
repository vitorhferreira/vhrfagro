<?php

use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();
});


Route::get('/vacinas', [VacinaController::class, 'index']);
Route::post('/cadvacinas', [VacinaController::class, 'store'])->name('vacina.store');

Route::get('/medico', [MedicoController::class, 'index']);
Route::post('/cadmedico', [MedicoController::class, 'store'])->name('medico.store');

Route::get('/pacientes', [PacienteController::class, 'index']);
Route::post('/cadpacientes', [PacienteController::class, 'store'])->name('paciente.store');

Route::get('/pacientes', [PacienteController::class, 'index']);
Route::post('/cadpacientes', [PacienteController::class, 'store'])->name('paciente.store');
