<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AcessoNegadoController;
use App\Http\Controllers\NomesController;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\CorpoEmailController;
use App\Http\Controllers\ListaDeEmailsController;
use App\Http\Controllers\ParaEnviarController;
use App\Http\Controllers\TituloListaDeEmailsController;

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

    Route::get('/corpoemail', [CorpoEmailController::class, 'index'])->name('corpoemail.index');
    Route::get('/corpoemail/create', [CorpoEmailController::class, 'create'])->name('corpoemail.create');
    Route::post('/corpoemail', [CorpoEmailController::class, 'store'])->name('corpoemail.store');
    Route::get('/corpoemail/{id}/edit', [CorpoEmailController::class, 'edit'])->name('corpoemail.edit');
    Route::post('/corpoemail/{id}', [CorpoEmailController::class, 'update'])->name('corpoemail.update');
    Route::get('/corpoemail/{id}/destroy', [CorpoEmailController::class, 'destroy'])->name('corpoemail.destroy');

    Route::get('/emails', [EmailsController::class, 'index'])->name('emails.index');
    Route::get('/emails/create', [EmailsController::class, 'create'])->name('emails.create');
    Route::post('/emails', [EmailsController::class, 'store'])->name('emails.store');
    Route::get('/emails/{id}/edit', [EmailsController::class, 'edit'])->name('emails.edit');
    Route::post('/emails/{id}', [EmailsController::class, 'update'])->name('emails.update');
    Route::get('/emails/{id}/destroy', [EmailsController::class, 'destroy'])->name('emails.destroy');

    Route::get('/listadeemails', [ListaDeEmailsController::class, 'index'])->name('listadeemails.index');
    Route::get('/listadeemails/create', [ListaDeEmailsController::class, 'create'])->name('listadeemails.create');
    Route::post('/listadeemails', [ListaDeEmailsController::class, 'store'])->name('listadeemails.store');
    Route::get('/listadeemails/{id}/edit', [ListaDeEmailsController::class, 'edit'])->name('listadeemails.edit');
    Route::post('/listadeemails/{id}', [ListaDeEmailsController::class, 'update'])->name('listadeemails.update');
    Route::get('/listadeemails/{id}/destroy', [ListaDeEmailsController::class, 'destroy'])->name('listadeemails.destroy');

    Route::get('/paraenviar', [ParaEnviarController::class, 'index'])->name('paraenviar.index');
    Route::get('/paraenviar/create', [ParaEnviarController::class, 'create'])->name('paraenviar.create');
    Route::post('/paraenviar', [ParaEnviarController::class, 'store'])->name('paraenviar.store');
    Route::get('/paraenviar/{id}/edit', [ParaEnviarController::class, 'edit'])->name('paraenviar.edit');
    Route::post('/paraenviar/{id}', [ParaEnviarController::class, 'update'])->name('paraenviar.update');
    Route::get('/paraenviar/{id}/destroy', [ParaEnviarController::class, 'destroy'])->name('paraenviar.destroy');
    Route::get('/paraenviar/{id}/alterarenvio', [ParaEnviarController::class, 'alterarEnvio'])->name('paraenviar.alterarenvio');

    Route::get('/titulolistadeemails', [TituloListaDeEmailsController::class, 'index'])->name('titulolistadeemails.index');
    Route::get('/titulolistadeemails/create', [TituloListaDeEmailsController::class, 'create'])->name('titulolistadeemails.create');
    Route::post('/titulolistadeemails', [TituloListaDeEmailsController::class, 'store'])->name('titulolistadeemails.store');
    Route::get('/titulolistadeemails/{id}/edit', [TituloListaDeEmailsController::class, 'edit'])->name('titulolistadeemails.edit');
    Route::post('/titulolistadeemails/{id}', [TituloListaDeEmailsController::class, 'update'])->name('titulolistadeemails.update');
    Route::get('/titulolistadeemails/{id}/destroy', [TituloListaDeEmailsController::class, 'destroy'])->name('titulolistadeemails.destroy');

});
