<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    /*
    register new user
    @param request $request
    @bodyParam email string required The email of the user.
    @bodyParam password string required The password of the user.
    @return Response UserResource
    */
    public function register(RegisterRequest $request){
       $user = new User();
       $user->name = $request->name;
       $user->email = $request->email;
       $user->password = Hash::make($request->password);
       $user->gender = $request->gender;
       $user->birth_date = $request->birth_date;
       $user->phone = $request->phone;
       $user->national_id = $request->national_id;
       if ($request->hasFile('image')){
           $user->image = $request->file('image')->store('images','public');
       }
       $user->save();
       if(!$user->hasVerifiedEmail())
            event(new Registered($user));
        $token = $user->createToken($request->email)->plainTextToken;
        return $this->sendResponse(['user' =>new UserResource($user),'token' =>$token],201);
    }
    /*
    Login For User
    @param Request
    @bodyParam email string required The email of the user.
    @bodyParam password string required The password of the user.
    @return Response UserResource
     */
    public function login(LoginRequest $request){
        $user = User::where(['email'=> $request->email])->first();
        if (!$user || !Hash::check($request->password , $user->password) )
                return $this->sendError('The provided credentials are incorrect',403);
            $user->update([ 'last_login'=> Carbon::now() ]);
            Auth::setUser($user);
            $token = $user->createToken($request->email)->plainTextToken;
            return $this->sendResponse(['user'=> new UserResource($user),'token' => $token]);

    }
    public function logout(Request $request){
        $user = $request->user();
        $user->tokens()->where('name', $user->currentAccessToken()->name)->delete();
        return $this->sendResponse(['message' => 'Logged out']);
    }
}
