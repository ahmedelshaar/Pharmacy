<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrdersController;
use App\Http\Controllers\API\UserAddressController;
use App\Http\Controllers\API\UserController;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('user', [UserController::class, 'index']);
    Route::put('user', [UserController::class, 'update']);
    Route::delete('user', [UserController::class, 'destroy']);
    // user addresses
    Route::get('user_addresses', [UserAddressController::class, 'index']);
    Route::post('user_addresses', [UserAddressController::class, 'store']);
    Route::put('user_addresses/{user_address}', [UserAddressController::class, 'update']);
    Route::delete('user_addresses/{user_address}', [UserAddressController::class, 'destroy']);
    // order
    Route::get('orders', [OrdersController::class, 'index']);
    Route::get('orders/{order}', [OrdersController::class, 'show']);
    Route::post('orders', [OrdersController::class, 'store']);
    Route::post('orders/{order}/cancel', [OrdersController::class, 'cancel']);
    Route::post('orders/{order}/confirm', [OrdersController::class, 'confirm']);
});


Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/sanctum/token', [AuthController::class, 'token'])->middleware('auth:sanctum');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'verification'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');
