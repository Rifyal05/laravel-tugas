<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;


Route::apiResource('/product-categories', ProductCategoryController::class);
Route::apiResource('/products', ProductController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});