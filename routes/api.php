<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SaleController;
use App\Models\Sale;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('products')->controller(ProductController::class)->group(function () {
    Route::get('/available', 'getAvailable'); //Listar produtos disponíveis
});

Route::prefix('sales')->controller(SaleController::class)->group(function () {
    Route::post('/', 'store'); //Cadastrar nova venda
    Route::get('/', 'getAll'); //Consultar vendas realizadas
    Route::get('/{id}', 'getById'); //Consultar uma venda específica
    Route::get('/{id}/cancel', 'cancel'); //Cancelar uma venda
    Route::post('/{id}/edit', 'update'); //Cadastrar novas produtos a uma venda
});
