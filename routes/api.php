<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

Route::prefix('v1')->group(function () {
    //Auth
    Route::middleware('throttle:api')->controller(AuthController::class)->group(function(){
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::middleware('auth:sanctum')->get('logout', 'logout');
    });

//Category
    Route::middleware(['throttle:api', 'auth:sanctum', 'isadmin'])->controller(CategoryController::class)->group(function(){
        Route::get('categories', 'index');
        Route::post('categories', 'store');
        Route::get('categories/{category}', 'show');
        Route::put('categories/{category}', 'update');
        Route::delete('categories/{category}', 'destroy');
    });


//Product
    Route::middleware(['throttle:api', 'auth:sanctum', 'isadmin'])->controller(ProductController::class)->group(function(){
        Route::get('products', 'index');
        Route::post('products', 'store');
        Route::get('products/{product}', 'show');
        Route::put('products/{product}', 'update');
        Route::delete('products/{product}', 'destroy');
    });
});


