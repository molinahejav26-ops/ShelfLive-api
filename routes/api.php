<?php
require __DIR__ . '/auth.php';

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('items', ItemController::class);
});
