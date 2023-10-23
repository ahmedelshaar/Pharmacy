<?php

namespace App\Http\Controllers\Api;


use App\Models\User;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgetPasswordController extends BaseController
{
    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->sendError([
                'message' => 'We can\'t find a user with that email address.'
            ], 404);
        }
        $broker = Password::broker();
        $broker->sendResetLink(['email' => $user->email]);
        return $this->sendResponse([
            'message' => 'We have e-mailed your password reset link!'
        ]);

    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->sendError([
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
            return  $this->sendError(['message' => 'This password reset token is invalid.'],400);
        }

        if ($status == Password::PASSWORD_RESET) {
            $user->tokens()->delete();
          return $this->sendResponse([ 'message' => 'Password reset successfully']);
        }
    }
}
