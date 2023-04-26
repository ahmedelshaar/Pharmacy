<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrdersController;
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
//    Route::resource('users', UserController::class)->except(['create', 'edit', 'show', 'update', 'destroy']);
    Route::put('/users', [UserController::class, 'update']);
    Route::delete('/users', [UserController::class, 'destroy']);
    Route::get('/orders', [OrdersController::class, 'index']);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/sanctum/token', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

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

// Verify Email
Route::get('/email/verify/{id}/{hash}', function (Request $request) {
// Auth::User verify his own email not others
    if ($request->route('id') != $request->user()->getKey()) {
        return response()->json([
            'message' => 'Invalid Verification Link'
        ], 403);
    }
    if (!hash_equals((string)$request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
        return response()->json([
            'message' => 'Invalid Verification Link'
        ], 403);
    }
    if ($request->user()->hasVerifiedEmail()) {
        return response()->json([
            'message' => 'Email already verified'
        ]);
    }
    if ($request->user()->markEmailAsVerified()) {
        event(new Verified($request->user()));
    }
//    Send Welcome Notification
    $request->user()->notify(new WelcomeNotification($request->user()));

    return response()->json([
        'message' => 'Email successfully verified'
    ]);
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

// Send reset Password Link
Route::post('/forgot-password', function (Request $request) {
    $request->validate([
        'email' => 'required|email'
    ]);
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json([
            'message' => 'We can\'t find a user with that email address.'
        ], 404);
    }
    Password::sendResetLink($request->only('email'));
    return response()->json([
        'message' => 'We have e-mailed your password reset link!'
    ]);
});

// Reset Password
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed'
    ]);
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json([
            'message' => 'We can\'t find a user with that email address.'
        ], 404);
    }
    $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user) use ($request) {
            $user->forceFill([
                'password' => Hash::make($request->password)
            ])->setRememberToken(Str::random(60));
            $user->save();
        });
    if ($status == Password::INVALID_TOKEN) {
        return response()->json([
            'message' => 'This password reset token is invalid.'
        ], 400);
    }

    if ($status == Password::PASSWORD_RESET) {
        $user->tokens()->delete();
        return response()->json([
            'message' => 'Password reset successfully'
        ]);
    }
});


