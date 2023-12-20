<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\pagamentosController;
use App\Http\Controllers\PayerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentIntentionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function (){

    Route::prefix('auth')->group(function (){
        Route::get('/', [LoginController::class, 'show'])->middleware('keycloak');;
        Route::post('/register', [LoginController::class, 'register']);
        Route::post('/token', [LoginController::class, 'token']);
        Route::post('/logout', [LoginController::class, 'logout']);
    });


    Route::middleware(['keycloak'])->group(function () {
        Route::prefix('companies')->group(function (){
            Route::get('/', [CompanyController::class, 'index']);
            Route::post('/', [CompanyController::class, 'store']);
            Route::prefix('{companyUuid}')->group(function () {
                Route::put('/', [CompanyController::class, 'update']);
                Route::get('/', [CompanyController::class, 'show']);
            });
        });

        Route::prefix('gateways')->group(function (){
            Route::post('/', [GatewayController::class, 'store']);
            Route::get('/', [GatewayController::class, 'index']);
            Route::prefix('{gatewayUuid}')->group(function () {
                Route::put('/', [GatewayController::class, 'update']);
                Route::get('/', [GatewayController::class, 'show']);
            });
        });

        Route::prefix('payers')->group(function (){
            Route::post('/', [PayerController::class, 'store']);
            Route::get('/', [PayerController::class, 'index']);
            Route::prefix('{payerUuid}')->group(function () {
                Route::put('/', [PayerController::class, 'update']);
                Route::get('/', [PayerController::class, 'show']);
            });
        });

        Route::prefix('payments')->group(function (){
            Route::post('/', [PaymentController::class, 'store']);
            Route::get('/', [PaymentController::class, 'index']);
            Route::prefix('{paymentUuid}')->group(function () {
                Route::put('/', [PaymentController::class, 'update']);
                Route::get('/', [PaymentController::class, 'show']);
                Route::post('/webhook', [PaymentController::class, 'webhook']);
            });
        });

        Route::prefix('intentions')->group(function (){
            Route::post('/', [PaymentIntentionController::class, 'store']);
            Route::get('/', [PaymentIntentionController::class, 'index']);
            Route::prefix('{intentionUuid}')->group(function () {
                Route::put('/', [PaymentIntentionController::class, 'update']);
                Route::get('/', [PaymentIntentionController::class, 'show']);
                Route::post('/webhook', [PaymentIntentionController::class, 'webhook']);
            });
        });

        Route::prefix('refunds')->group(function (){
            Route::post('/', [PaymentIntentionController::class, 'store']);
            Route::get('/', [PaymentIntentionController::class, 'show']);
            Route::prefix('{refundUuid}')->group(function () {
                Route::put('/', [PaymentIntentionController::class, 'update']);
                Route::get('/', [PaymentIntentionController::class, 'showByUuid']);
            });
        });
    });
});

Route::post('/process_payment',    [pagamentosController::class, 'createPayment']);
Route::post('/process_refund',    [pagamentosController::class, 'createRefund']);
