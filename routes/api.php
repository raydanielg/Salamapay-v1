<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ─── Public Auth Routes ───────────────────────────────────────────────────────
Route::post('/login',    [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

// ─── Authenticated Routes ─────────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/user',    [App\Http\Controllers\Api\AuthController::class, 'me']);

    // Dashboard
    Route::get('/user/dashboard', [App\Http\Controllers\Api\DashboardController::class, 'index']);

    // Sales / Transactions
    Route::get('/user/sales',                   [App\Http\Controllers\Api\SalesController::class, 'index']);
    Route::delete('/user/sales/{transaction}',   [App\Http\Controllers\Api\SalesController::class, 'destroy']);

    // Invoices
    Route::get('/user/invoices',                    [App\Http\Controllers\Api\InvoiceApiController::class, 'index']);
    Route::post('/user/invoices',                   [App\Http\Controllers\Api\InvoiceApiController::class, 'store']);
    Route::get('/user/invoices/{invoice}',          [App\Http\Controllers\Api\InvoiceApiController::class, 'show']);
    Route::put('/user/invoices/{invoice}',          [App\Http\Controllers\Api\InvoiceApiController::class, 'update']);
    Route::delete('/user/invoices/{invoice}',       [App\Http\Controllers\Api\InvoiceApiController::class, 'destroy']);
    Route::post('/user/invoices/{invoice}/pay',     [App\Http\Controllers\Api\InvoiceApiController::class, 'pay']);

    // Products
    Route::get('/user/products',                [App\Http\Controllers\Api\ProductApiController::class, 'index']);
    Route::post('/user/products',               [App\Http\Controllers\Api\ProductApiController::class, 'store']);
    Route::put('/user/products/{product}',      [App\Http\Controllers\Api\ProductApiController::class, 'update']);
    Route::delete('/user/products/{product}',   [App\Http\Controllers\Api\ProductApiController::class, 'destroy']);

    // Reports
    Route::get('/user/reports', [App\Http\Controllers\Api\ReportsApiController::class, 'index']);
});
