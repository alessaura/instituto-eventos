<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ParticipacaoController;
use App\Http\Controllers\ImportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rota principal - Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Rotas de recursos
Route::resource('eventos', EventoController::class);
Route::resource('pessoas', PessoaController::class);
Route::resource('participacoes', ParticipacaoController::class);

// Rotas de importação
Route::get('/import', [ImportController::class, 'index'])->name('import.index');
Route::post('/import/pessoas', [ImportController::class, 'importPessoas'])->name('import.pessoas');
Route::post('/import/participacoes', [ImportController::class, 'importParticipacoes'])->name('import.participacoes');

// Rota para associar pessoa a evento
Route::post('/eventos/{evento}/participantes', [ParticipacaoController::class, 'store'])->name('eventos.participantes.store');
