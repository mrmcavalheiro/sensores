<?php

// routes/web.php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NavegationController;
use App\Http\Controllers\SendMailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\SoloController;
use App\Http\Controllers\BoletinsController;

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

// Pagina de Contato
Route::get('/contato', [NavegationController::class, 'contato'])->name('contato');

// Envio de Mensagem
Route::post('/contato', [SendMailController::class, 'contato'])->name('novocontato');

// Pagina Principal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Pagina projeto
// Route::get('/projeto', [NavegationController::class, 'projeto'])->name('projeto');

// Pagina apoiadores
// Route::get('/apoiadores', [NavegationController::class, 'apoiadores'])->name('apoiadores');

// Pagina Sobre
Route::get('/sobre', [NavegationController::class, 'sobre'])->name('sobre');

// Pagina Boletins
Route::get('/boletins', [NavegationController::class, 'boletins'])->name('boletins');

// Pagina Análise de Solo
//Route::get('/solo', [NavegationController::class, 'solo'])->name('solo');


Route::get('/solo', [SoloController::class, 'solo'])->name('solo');


// Pagina Equipe
// Route::get('/equipe', [NavegationController::class, 'equipe'])->name('equipe');

// Envia e-mail com algum futuro contato
Route::post('/', [SendMailController::class, 'lead'])->name('lead');

// Para atualizar o gráfico

Route::post('/update-chart', [ChartController::class, 'updateChart'])->name('update-chart');
//Route::post('/update-chart', [ChartController::class, 'updateChart']);


Route::get('/boletins', [BoletinsController::class, 'index'])->name('boletins');

