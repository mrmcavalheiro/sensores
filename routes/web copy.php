<?php

// routes/web.php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NavegationController;
use App\Http\Controllers\SendMailController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('site.home');
// });
// Pagina de Contato
Route::get('/contato',[NavegationController::class,'contato'])->name('contato');

//Envio de Mensagem
Route::post('/contato',[SendMailController::class,'contato'])->name('novocontato');

//Pagina Principal
Route::get('/',[NavegationController::class,'home'])->name('home');
//Pagina apoiadores
Route::get('/apoiadores',[NavegationController::class,'apoiadores'])->name('apoiadores');
//Pagina Sobre
Route::get('/sobre',[NavegationController::class,'sobre'])->name('sobre');
//Pagina Análise de Solo
Route::get('/solo',[NavegationController::class,'solo'])->name('solo');
//Pagina Equipe
Route::get('/equipe',[NavegationController::class,'equipe'])->name('equipe');

// Envia e-mail com algum futuro contato
Route::post('/',[SendMailController::class,'lead'])->name('lead');


Route::get('/', [HomeController::class, 'index']);
Route::get('/carregar-dados', [HomeController::class, 'carregarDados']);
