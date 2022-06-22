<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;

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
    Route::get('/home/{id?}', [DashboardController::class, 'dashboardHome'])->name('dashboardHome');
    Route::get('/home/{id?}/ver', [DashboardController::class, 'dashboardVer'])->name('dashboardVer');
    Route::get('/home/{id?}/editar', [DashboardController::class, 'dashboardEdita'])->name('dashboardEdita');
    Route::post('home/{id?}/editar', [DashboardController::class, 'dashboardEditar'])->name('dashboardEditar');

});

