<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::middleware(['api'])->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify');
});

Route::middleware('auth:api')->group(function () {
    Route::get('email/resend', [AuthController::class, 'resend'])->name('verification.resend');
    Route::post('logout', [AuthController::class, 'logout']);
});
