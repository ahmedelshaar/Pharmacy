<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //Register
    public function register(StoreUserRequest $request)
    {
        $image = $request->file('image');
        $imgName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/users'), $imgName);
        $imgName = 'images/users/' . $imgName;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $imgName,
            'national_id' => $request->national_id,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'last_login' => now(),
        ]);
        $user->sendEmailVerificationNotification();
        event(new Registered($user));
        return response()->json([
            'message' => 'Verification email sent'
        ]);

//        $token = $user->createToken($request->email)->plainTextToken;
//        return response()->json([
//            'message' => 'Register successfully',
//            'token' => $token
//        ]);
    }

    //Login Function
    public function login(Request $request)
    {
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

        // create token for user and login
        $token = $user->createToken($request->email)->plainTextToken;

        if (!$user->hasVerifiedEmail()) {
            // todo 5na2a el token
            return response()->json([
                'message' => 'Please verify your email',
                'token' => $token
            ]);
        }
        return response()->json([
            'message' => 'Login successfully',
            'token' => $token
        ]);
    }

    //Logout
    public function logout(Request $request)
    {
        Auth::User()->tokens()->delete();
        return response()->json([
            'message' => 'Logout successfully'
        ]);
    }

    public function token(Request $request){
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
    }

    public function verify(Request $request){
//        if ($request->route('id') != $request->user()->getKey()) {
//            return response()->json([
//                'message' => 'Invalid Verification Link'
//            ], 403);
//        }
//        if (!hash_equals((string)$request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
//            return response()->json([
//                'message' => 'Invalid Verification Link'
//            ], 403);
//        }
//        if ($request->user()->hasVerifiedEmail()) {
//            return response()->json([
//                'message' => 'Email already verified'
//            ]);
//        }
//        if ($request->user()->markEmailAsVerified()) {
//            event(new Verified($request->user()));
//        }
//        $request->user()->notify(new WelcomeNotification($request->user()));
//
//        return response()->json([
//            'message' => 'Email successfully verified'
//        ]);

        $user = User::find($request->route('id'));
        if (!$user) {
            return response()->json([
                'message' => 'Invalid Verification Link'
            ], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email already verified'
            ]);
        }else {
            if (!hash_equals((string)$request->route('hash'), sha1($user->getEmailForVerification()))) {
                return response()->json([
                    'message' => 'Invalid Verification Link'
                ], 403);
            }
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        $token = $user->createToken($user->email)->plainTextToken;

        $user->notify(new WelcomeNotification($user));

        return response()->json([
            'message' => 'Email successfully verified',
            'token' => $token
        ]);
    }

    public function verification(Request $request){
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email already verified'
            ]);
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json([
            'message' => 'Email verification link sent on your email'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User with this email address not found.'
            ], 404);
        }

        Password::sendResetLink($request->only('email'));

        return response()->json([
            'message' => 'Password reset link sent to your email.'
        ]);
    }

    public function resetPassword(Request $request) {
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
    }
}
