<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OperationCashController;
use App\Http\Controllers\OperationProductController;
use App\Http\Controllers\OperationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResources([
    'companies' => CompanyController::class,
    'products' => ProductController::class,
]);

Route::prefix('operations')
->name('operations.')
->group(function() {
    Route::post('/cash', [OperationCashController::class, 'store'])->name('cash.store');
    Route::post('/products', [OperationProductController::class, 'store'])->name('products.store');
    Route::get('/balance', [OperationController::class, 'index'])->name('balance');
});
