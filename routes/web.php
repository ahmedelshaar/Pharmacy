<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderMedicineQuantityController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::get('/', function () {

    return view('admin.dashboard');

})->middleware(['auth:admin,doctor', 'verified', 'role:admin|owner|doctor']);
Route::middleware('auth:admin,doctor')->group(function () {

    Route::group(['middleware' => ['role:admin|owner']], function () {
        Route::prefix('/revenue')->group(function () {
            Route::get('/', [RevenueController::class, 'index'])->name('revenue.index');
            Route::get('/{id}', [RevenueController::class, 'show'])->name('revenue.show');
        });
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('/areas')->group(function () {
            Route::get('/', [AreaController::class, 'index'])->name('areas.index');
            Route::get('/create', [AreaController::class, 'create'])->name('areas.create');
            Route::post('/', [AreaController::class, 'store'])->name('areas.store');
            Route::get('{area}/edit', [AreaController::class, 'edit'])->name('areas.edit');
            Route::put('/{area}', [AreaController::class, 'update'])->name('areas.update');
            Route::delete('/{area}', [AreaController::class, 'destroy'])->name('areas.destroy');
        });
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('/users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        });
    });
    Route::group(['middleware' => ['role:admin|owner|doctor']], function () {
        Route::prefix('/medicines')->group(function () {
            Route::get('/', [MedicineController::class, 'index'])->name('medicines.index');
            Route::get('/create', [MedicineController::class, 'create'])->name('medicines.create');
            Route::post('/', [MedicineController::class, 'store'])->name('medicines.store');
            Route::delete('/{id}', [MedicineController::class, 'destroy'])->name('medicines.destroy');
            Route::get('/{id}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
            Route::put('/{id}', [MedicineController::class, 'update'])->name('medicines.update');
            Route::get('/{id}', [MedicineController::class, 'show'])->name('medicines.show');
        });
    });
    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('/addresses')->group(function () {
            Route::get('/', [UserAddressController::class, 'index'])->name('addresses.index');
            Route::delete('/{address}', [UserAddressController::class, 'destroy'])->name('addresses.destroy');
        });
    });

    Route::group(['middleware' => ['role:admin|owner|doctor']], function () {
        Route::prefix('/pharmacy')->group(function () {
            Route::get('/', [PharmacyController::class, 'index'])->name('pharmacies.index');
            Route::get('/create', [PharmacyController::class, 'create'])->name('pharmacies.create');
            Route::post('/', [PharmacyController::class, 'store'])->name('pharmacies.store');
            Route::get('{pharmacy}/edit', [PharmacyController::class, 'edit'])->name('pharmacies.edit');
            Route::put('/{pharmacy}', [PharmacyController::class, 'update'])->name('pharmacies.update');
            Route::delete('/{pharmacy}', [PharmacyController::class, 'destroy'])->name('pharmacies.destroy');
            Route::post('/pharmacies/{pharmacy}/restore', [PharmacyController::class, 'restore'])->name('pharmacies.restore');
        });
    });

    Route::prefix('/doctors')->group(function () {
        Route::get('/', [DoctorController::class, 'index'])->name('doctors.index');
        Route::delete('/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
        Route::get('/create', [DoctorController::class, 'create'])->name('doctors.create');
        Route::post('/', [DoctorController::class, 'store'])->name('doctors.store');

        Route::get('/{id}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
        Route::put('/{id}', [DoctorController::class, 'update'])->name('doctors.update');
        Route::put('/{id}/ban', [DoctorController::class, 'ban'])->name('doctors.ban');
        Route::put('/{id}/unban', [DoctorController::class, 'unban'])->name('doctors.unban');
    });
    Route::prefix('owners/')->group(function () {
        Route::get('/', [OwnerController::class, 'index'])->name('owners.index');
        Route::delete('/{id}', [OwnerController::class, 'destroy'])->name('owners.destroy');
        Route::get('/create', [OwnerController::class, 'create'])->name('owners.create');
        Route::post('/', [OwnerController::class, 'store'])->name('owners.store');
        Route::get('/{id}/edit', [OwnerController::class, 'edit'])->name('owners.edit');
        Route::put('/{id}', [OwnerController::class, 'update'])->name('owners.update');
//        Route::put('/{id}/ban', [OwnerController::class, 'ban'])->name('owners.ban');
//        Route::put('/{id}/unban', [OwnerController::class, 'unban'])->name('owners.unban');
    });

    Route::prefix('/orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::delete('/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::post('/{id}', [OrderMedicineQuantityController::class, 'store'])->name('medicineQuantity.store');
        Route::delete('/{id}/remove', [OrderMedicineQuantityController::class, 'destroy'])->name('medicineQuantity.destroy');
        Route::put('/{id}', [OrderMedicineQuantityController::class, 'update'])->name('orders.update');

    });

});

Route::group([], function () {
    Route::prefix('/payments')->group(function () {
        Route::get('/', [StripeController::class, 'stripe'])->name('stripe');
        Route::get('/{id}/success', [StripeController::class, 'stripeSuccess'])->name('stripe.success');
        Route::get('/{id}/cancel', [StripeController::class, 'stripeCancel'])->name('stripe.cancel');
        Route::get('/{id}/status', [StripeController::class, 'status'])->name('order.status');
    });
});
Route::post('/administration-logout', function (Request $request) {
    $guard = Auth::guard()->name;
    Auth::guard($guard)->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return to_route("login");
})->name('administration-logout');

Auth::routes(['register' => false]);


