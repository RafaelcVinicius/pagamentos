<?php

use App\Http\Controllers\pagamentosController;
use Illuminate\Http\Request;
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

Route::get('/',    [pagamentosController::class, 'index']);
Route::post('/create',    [pagamentosController::class, 'create']);
Route::get('/payment/{id}',    [pagamentosController::class, 'paymentByCompany'])->name("payment");
Route::get('/show/{id}',    [pagamentosController::class, 'show']);
