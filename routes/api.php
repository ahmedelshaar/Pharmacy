<?php

use App\Http\Controllers\API\UserController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
//Route::group(['middleware' => ['auth:sanctum']], function () {
Route::resource('users', UserController::class);
//});

// Sanctum register route


// Sanctum login route
Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'The provided credentials are incorrect.'
        ], 401);
    }
    $user->update(['last_login' => Carbon::now()]);
    $token = $user->createToken($request->email)->plainTextToken;

    if (!$user->hasVerifiedEmail()) {
        return response()->json([
            'message' => 'Please verify your email',
            'token' => $token
        ]);
    }

    return response()->json([
        'message' => 'Login successfully',
        'token' => $token
    ]);
});
//Email Verification Handler api
//Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest  $request) {
//    $request->fulfill();
//    return response()->json([
//        'message' => 'Email verified successfully'
//    ]);
//})->middleware(['auth:sanctum','signed'])->name('verification.verify');
Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $user = User::find($request->id);
    if ($user->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified!']);
    }

    if ($user->markEmailAsVerified()) {
        event(new Verified($user));
    }

    return response()->json(['message' => 'Email verified successfully!']);
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

// Resend Email Verification
Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return response()->json([
            'message' => 'Email already verified'
        ]);
    }
    $request->user()->sendEmailVerificationNotification();
    return response()->json([
        'message' => 'Email verification link sent on your email'
    ]);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
