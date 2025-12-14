<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('expenses/analyze', [ExpenseController::class, 'analyzeExpenses']);
    Route::apiResource('expenses', ExpenseController::class);
    Route::apiResource('categories', CategoryController::class);
});



