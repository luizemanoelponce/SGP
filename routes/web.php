<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoricoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function(){
    
    Route::get('/home/adicionar', [DashboardController::class, 'dashboardAdiciona'])->name('dashboardAdiciona');
    Route::post('home/adicionar', [DashboardController::class, 'dashboardAdicionar'])->name('dashboardAdicionar');
    Route::get('/home/adicionar/historico/{id?}', [HistoricoController::class, 'AdicionaHistorico'])->name('AdicionaHistorico');
    Route::post('home/adicionar/historico', [HistoricoController::class, 'AdicionarHistorico'])->name('AdicionarHistorico');
    Route::get('/home/adicionar/categoria', [DashboardController::class, 'dashboardAdicionaCategoria'])->name('dashboardAdicionaCategoria');
    Route::post('home/adicionar/categoria', [DashboardController::class, 'dashboardAdicionarCategoria'])->name('dashboardAdicionarCategoria');
    Route::get('/home/adicionar/Atributo/categoria/{id?}', [DashboardController::class, 'dashboardAdicionaAtributoCategoria'])->name('dashboardAdicionaAtributoCategoria');
    Route::post('home/adicionar/Atributo/categoria/', [DashboardController::class, 'dashboardAdicionarAtributoCategoria'])->name('dashboardAdicionarAtributoCategoria');
    Route::get('/home/ver/Tarefa/{id?}', [DashboardController::class, 'dashboardTarefaVer'])->name('dashboardTarefaVer');
    Route::get('/home/concluir/Tarefa/{id?}', [DashboardController::class, 'dashboardTarefaConcluir'])->name('dashboardTarefaConcluir');
    Route::get('/home/adicionar/Tarefa/{id?}', [DashboardController::class, 'dashboardAdicionaTarefa'])->name('dashboardAdicionaTarefa');
    Route::post('home/adicionar/Tarefa', [DashboardController::class, 'dashboardAdicionarTarefa'])->name('dashboardAdicionarTarefa');
    Route::get('/home/{id?}', [DashboardController::class, 'dashboardHome'])->name('dashboardHome');
    Route::get('/home/{id?}/ver', [DashboardController::class, 'dashboardVer'])->name('dashboardVer');
    Route::get('/home/{id?}/editar', [DashboardController::class, 'dashboardEdita'])->name('dashboardEdita');
    Route::post('home/{id?}/editar', [DashboardController::class, 'dashboardEditar'])->name('dashboardEditar');
    Route::get('/home/{id?}/excluir', [DashboardController::class, 'dashboardExclui'])->name('dashboardExclui');
    Route::post('home/{id?}/excluir', [DashboardController::class, 'dashboardExcluir'])->name('dashboardExcluir');

});

