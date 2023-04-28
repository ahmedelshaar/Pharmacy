<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderMedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'auth'], function (){
    Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::resource('doctor', DoctorController::class);
    Route::resource('area', AreaController::class);
    Route::resource('order', OrderController::class);
    Route::resource('pharmacy', PharmacyController::class);

    Route::resource('medicine', MedicineController::class)->except(['show']);
    Route::resource('order', OrderController::class);
    Route::resource('order_medicine', OrderMedicineController::class);
    Route::resource('pharmacy', PharmacyController::class);
    Route::resource('user_address', UserAddressController::class);
    Route::resource('user', UserController::class);

});

Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
