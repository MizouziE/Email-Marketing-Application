<?php

use App\Http\Controllers\ClientsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
    return redirect('/home');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/clients',  [ClientsController::class, 'index']);
    Route::get('/clients/create',  [ClientsController::class, 'create']);
    Route::post('/clients', [ClientsController::class, 'store']);
    Route::get('/clients/{client}', [ClientsController::class, 'show']);

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});


Auth::routes();
