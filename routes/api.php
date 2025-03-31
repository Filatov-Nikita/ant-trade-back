<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OperationCashController;
use App\Http\Controllers\OperationProductController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/auth/user', [AuthController::class, 'showUser'])->name('auth.user');

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
    Route::delete('/remove-file/{file}', [FileController::class, 'destroy'])->name('file.destroy');
});
