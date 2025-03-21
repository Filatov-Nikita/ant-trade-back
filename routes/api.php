<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OperationCashController;
use App\Http\Controllers\OperationProductController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\FileController;

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
    Route::put('/{operation}/cash', [OperationCashController::class, 'update'])->name('cash.update');
    Route::post('/products', [OperationProductController::class, 'store'])->name('products.store');
    Route::put('/{operation}/products', [OperationProductController::class, 'update'])->name('products.update');
    Route::get('/balance', [OperationController::class, 'index'])->name('balance');
    Route::get('/{operation}', [OperationController::class, 'show'])->name('show');
    Route::delete('/{operation}', [OperationController::class, 'destroy'])->name('destroy');
});

Route::post('/upload-file', [FileController::class, 'store'])->name('file.upload');
