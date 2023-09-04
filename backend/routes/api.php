<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductsController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [AuthController::class, 'resend']);

Route::get('/getProducts', [ProductsController::class, 'getProducts']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/updateProfile', [AuthController::class, 'updateProfile']);
    Route::post('/changePassword', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/saveProduct', [ProductsController::class, 'saveProduct']);
    Route::delete('/deleteProduct', [ProductsController::class, 'deleteProduct']);

    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::post('/cart/remove', [CartController::class, 'removeItem']);
    Route::post('/cart/items', [CartController::class, 'getCartItems']);
});
