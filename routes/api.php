<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserAddressController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class,'logout']);
Route::post('/forget-password', [ForgetPasswordController::class,'forgetPassword']);
Route::post('/reset-password', [ForgetPasswordController::class,'resetPassword']);


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['success' => 'Verified']);
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::prefix('/users')->middleware(['auth:sanctum','verified'])->group(function () {
    Route::get('/',[UserController::class,'show'])->name('users.show');
   Route::put('/',[UserController::class,'update'])->name('users.update');
});

Route::prefix('/addresses')->middleware(['auth:sanctum','verified'])->group(function () {
    Route::get('/', [UserAddressController::class, 'index'])->name('addresses.index');
    Route::post('/', [UserAddressController::class, 'store'])->name('addresses.store');
    Route::get('{address}', [UserAddressController::class,'show'])->name('addresses.show');
    Route::put('/{address}', [UserAddressController::class, 'update'])->name('addresses.update');
    Route::delete('/{address}', [UserAddressController::class, 'destroy'])->name('addresses.destroy');
});
Route::prefix('orders')->middleware(['auth:sanctum','verified'])->group(function(){
    Route::get('/',[OrderController::class,'index'])->name('orders.index');
    Route::get('/{order}',[OrderController::class,'show'])->name('orders.show');
    Route::post('/',[OrderController::class,'store'])->name('orders.store');
    Route::post('/{order}',[OrderController::class,'update'])->middleware('check_order_status')->name('orders.update'); // PUT -- Update order when status new only


});

