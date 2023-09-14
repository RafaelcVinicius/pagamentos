<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\pagamentosController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentIntentionController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('company')->group(function (){
    Route::post('/', [CompanyController::class, 'store']);
    Route::get('/', [CompanyController::class, 'show']);
    Route::prefix('{uuid}')->group(function () {
        Route::put('/', [CompanyController::class, 'update']);
        Route::get('/', [CompanyController::class, 'showByUuid']);
    });
});

Route::prefix('payments')->group(function (){
    Route::prefix('payment')->group(function (){
        Route::post('/', [PaymentController::class, 'store']);
        Route::get('/', [PaymentController::class, 'show']);
        Route::prefix('{uuid}')->group(function () {
            Route::put('/', [PaymentController::class, 'update']);
            Route::get('/', [PaymentController::class, 'showByUuid']);
        });
    });

    Route::prefix('intention')->group(function (){
        Route::post('/', [PaymentIntentionController::class, 'store']);
        Route::get('/', [PaymentIntentionController::class, 'show']);
        Route::prefix('{uuid}')->group(function () {
            Route::put('/', [PaymentIntentionController::class, 'update']);
            Route::get('/', [PaymentIntentionController::class, 'showByUuid']);
        });
    });
});

Route::prefix('gateway')->group(function (){
    Route::post('/', [GatewayController::class, 'store']);
    Route::get('/', [GatewayController::class, 'show']);
    Route::prefix('{uuid}')->group(function () {
        Route::put('/', [GatewayController::class, 'update']);
        Route::get('/', [GatewayController::class, 'showByUuid']);
    });
});




Route::post('/process_payment',    [pagamentosController::class, 'createPayment']);
Route::post('/process_refund',    [pagamentosController::class, 'createRefund']);
