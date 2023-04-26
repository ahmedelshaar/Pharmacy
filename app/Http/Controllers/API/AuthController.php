<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Register
    public function register(StoreUserRequest $request)
    {
        $imgName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imgName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/users');
            $image->move($destinationPath, $imgName);
        }
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
        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
            'message' => 'Register successfully',
            'token' => $token
        ]);
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

    //Logout
    public function logout(Request $request)
    {
        Auth::User()->tokens()->delete();
        return response()->json([
            'message' => 'Logout successfully'
        ]);
    }
}
