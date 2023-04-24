<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderMedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\UserAddressController;
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

Route::get('/',function (){
   return view('admin.dashboard');
});

Route::prefix('/doctor')->group(function () {
    Route::get('/', [\App\Http\Controllers\DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/create', [\App\Http\Controllers\DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/store', [\App\Http\Controllers\DoctorController::class, 'store'])->name('doctor.store');
    Route::get('/{doctor}/edit', [\App\Http\Controllers\DoctorController::class, 'edit'])->name('doctor.edit');
    Route::put('/{doctor}', [\App\Http\Controllers\DoctorController::class, 'update'])->name('doctor.update');
    Route::delete('/{doctor}', [\App\Http\Controllers\DoctorController::class, 'destroy'])->name('doctor.destroy');
    Route::get('/data', [\App\Http\Controllers\DoctorController::class, 'data'])->name('doctor.data');
});

//Areas
Route::prefix('/areas')->group(function () {
     Route::get('/', [\App\Http\Controllers\AreaController::class, 'index'])->name('areas.index');
     Route::get('/create', [\App\Http\Controllers\AreaController::class, 'create'])->name('areas.create');
     Route::post('/store', [\App\Http\Controllers\AreaController::class, 'store'])->name('areas.store');
     Route::get('/{area}/edit', [\App\Http\Controllers\AreaController::class, 'edit'])->name('areas.edit');
     Route::put('/{area}', [\App\Http\Controllers\AreaController::class, 'update'])->name('areas.update');
     Route::delete('/{area}', [\App\Http\Controllers\AreaController::class, 'destroy'])->name('areas.destroy');

    
});


//Route::resource('doctor', DoctorController::class);
//Route::resource('area', AreaController::class);
//Route::resource('medicine', MedicineController::class);
//Route::resource('order', OrderController::class);
//Route::resource('order_medicine', OrderMedicineController::class);
//Route::resource('pharmacy', PharmacyController::class);
//Route::resource('user_address', UserAddressController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
