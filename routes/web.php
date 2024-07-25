<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AcessoNegadoController;
use App\Http\Controllers\NomesController;
use App\Http\Controllers\MensagemController;
use App\Http\Controllers\ListaDeEnviosController;
use App\Http\Controllers\ParaEnviarController;
//use App\Http\Controllers\TituloListaDeEmailsController;
use App\Http\Controllers\ConfiguracoesUsuarioController;
use App\Http\Controllers\AnexosController;
use App\Http\Controllers\InformacoesDeEnviosController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/registrese', [AuthController::class, 'create'])->name('registrese');
Route::post('/store', [AuthController::class, 'store'])->name('store');
Route::post('/logar', [AuthController::class, 'logar'])->name('logar');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/403', [AcessoNegadoController::class , 'acessoNegado403'])->name('403');


Route::middleware(['auth'])->group(function() {

    Route::get('/nomes', [NomesController::class, 'index'])->name('nomes.index');
    Route::get('/nomes/create', [NomesController::class, 'create'])->name('nomes.create');
    Route::post('/nomes', [NomesController::class, 'store'])->name('nomes.store');
    Route::get('/nomes/{id}/edit', [NomesController::class, 'edit'])->name('nomes.edit');
    Route::post('/nomes/{id}', [NomesController::class, 'update'])->name('nomes.update');
    Route::get('/nomes/{id}/destroy', [NomesController::class, 'destroy'])->name('nomes.destroy');

    Route::get('/mensagem', [MensagemController::class, 'index'])->name('mensagem.index');
    Route::get('/mensagem/create', [MensagemController::class, 'create'])->name('mensagem.create');
    Route::post('/mensagem', [MensagemController::class, 'store'])->name('mensagem.store');
    Route::get('/mensagem/{id}/edit', [MensagemController::class, 'edit'])->name('mensagem.edit');
    Route::post('/mensagem/{id}', [MensagemController::class, 'update'])->name('mensagem.update');
    Route::get('/mensagem/{id}/destroy', [MensagemController::class, 'destroy'])->name('mensagem.destroy');

    Route::get('/informacoesdeenvios', [InformacoesDeEnviosController::class, 'index'])->name('envios.index');
    Route::get('/informacoesdeenvios/create', [InformacoesDeEnviosController::class, 'create'])->name('envios.create');
    Route::post('/informacoesdeenvios', [InformacoesDeEnviosController::class, 'store'])->name('envios.store');
    Route::get('/informacoesdeenvios/{id}/edit', [InformacoesDeEnviosController::class, 'edit'])->name('envios.edit');
    Route::post('/informacoesdeenvios/{id}', [InformacoesDeEnviosController::class, 'update'])->name('envios.update');
    Route::get('/informacoesdeenvios/{id}/destroy', [InformacoesDeEnviosController::class, 'destroy'])->name('envios.destroy');

    Route::get('/listadeenvios/receivelistemails', [ListaDeEnviosController::class, 'receiveListEmails'])->name('listadeenvios.receivelistemails');
    Route::post('/listadeenvios/storelistemails', [ListaDeEnviosController::class, 'storeListEmails'])->name('listadeenvios.storelistemails');
    Route::get('/listadeenvios', [ListaDeEnviosController::class, 'index'])->name('listadeenvios.index');
    Route::get('/listadeenvios/create', [ListaDeEnviosController::class, 'create'])->name('listadeenvios.create');
    Route::post('/listadeenvios', [ListaDeEnviosController::class, 'store'])->name('listadeenvios.store');
    Route::get('/listadeenvios/{id}/edit', [ListaDeEnviosController::class, 'edit'])->name('listadeenvios.edit');
    Route::post('/listadeenvios/{id}', [ListaDeEnviosController::class, 'update'])->name('listadeenvios.update');
    Route::get('/listadeenvios/{id}/destroy', [ListaDeEnviosController::class, 'destroy'])->name('listadeenvios.destroy');

    Route::get('/paraenviar', [ParaEnviarController::class, 'index'])->name('paraenviar.index');
    Route::get('/paraenviar/create', [ParaEnviarController::class, 'create'])->name('paraenviar.create');
    Route::post('/paraenviar', [ParaEnviarController::class, 'store'])->name('paraenviar.store');
    Route::get('/paraenviar/{id}/edit', [ParaEnviarController::class, 'edit'])->name('paraenviar.edit');
    Route::post('/paraenviar/{id}', [ParaEnviarController::class, 'update'])->name('paraenviar.update');
    Route::get('/paraenviar/{id}/destroy', [ParaEnviarController::class, 'destroy'])->name('paraenviar.destroy');
    Route::get('/paraenviar/{id}/alterarenvio', [ParaEnviarController::class, 'alterarEnvio'])->name('paraenviar.alterarenvio');

    Route::get('/anexos/{vinculador_anexos_id}', [AnexosController::class, 'index'])->name('anexos.index');
    Route::get('/anexos/create/{vinculador_anexos_id}', [AnexosController::class, 'create'])->name('anexos.create');
    Route::get('/anexos/novoAnexo/{mensagem_id}', [AnexosController::class, 'novoAnexo'])->name('anexos.novoAnexo');
    Route::post('/anexos/{vinculador_anexos_id}', [AnexosController::class, 'store'])->name('anexos.store');
    Route::post('/anexos/{mensagem_id}/storeNovoAnexo', [AnexosController::class, 'storeNovoAnexo'])->name('anexos.storeNovoAnexo');
    Route::get('/anexos/{id}/{vinculador_anexos_id}/edit', [AnexosController::class, 'edit'])->name('anexos.edit');
    Route::post('/anexos/{id}/{vinculador_anexos_id}', [AnexosController::class, 'update'])->name('anexos.update');
    Route::get('/anexos/{id}/{vinculador_anexos_id}/destroy', [AnexosController::class, 'destroy'])->name('anexos.destroy');

    Route::get('/configuracoesusuario/edit/{id}', [ConfiguracoesUsuarioController::class, 'edit'])->name('configuracoesusuario.edit');
    Route::post('/configuracoesusuario/{id}', [ConfiguracoesUsuarioController::class, 'update'])->name('configuracoesusuario.update');
    Route::get('/configuracoesusuario/destroyimg/{id}', [ConfiguracoesUsuarioController::class, 'destroyimg'])->name('configuracoesusuario.destroyimg');
    Route::get('/configuracoesusuario/downloadassinatura/{id}', [ConfiguracoesUsuarioController::class, 'downloadAssinatura'])->name('configuracoesusuario.downloadassinatura');

});
