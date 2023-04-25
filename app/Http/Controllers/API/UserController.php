<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(Auth::user());
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->fill($request->except('email', 'image'));
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imgName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/users/');
            $image->move($destinationPath, $imgName);

            if (file_exists(public_path(Auth::user()->image))) {
                @unlink(public_path(Auth::user()->image));
            }
            $user->image = '/images/users/' . $imgName;
        }
        $user->save();
        return response()->json(Auth::user());
    }
    
    public function destroy()
    {
        if (Auth::user()->orders()->exists()) {
            return response()->json('User Has Orders Can\'t Delete');
        }
        if (file_exists(public_path(Auth::user()->image))) {
            @unlink(public_path(Auth::user()->image));
        }
        Auth::user()->delete();
        return response()->json(['message' => 'User Deleted Successfully']);
    }
}
