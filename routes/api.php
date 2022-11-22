<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Get all products
Route::get('/products', [ProductController::class, 'index']);

// Get a single product
Route::get('/products/{id}', [ProductController::class, 'show']);

// Search a product
Route::get('/products/search/{name}', [ProductController::class, 'search']);

// Protected Routes
Route::group(['middleware' => 'auth:sanctum'], function(){

    // Create a new product
    Route::post('/products', [ProductController::class, 'store']);

    // Update a product
    Route::put('/products/{id}', [ProductController::class, 'update']);

    // Destroy a product
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    
    // Logout a user
    Route::post('/logout', [UserController::class, 'logout']);

});

// Create a new user
Route::post('/register', [UserController::class, 'register']);

// Login a user
Route::post('/login', [UserController::class, 'login']);
