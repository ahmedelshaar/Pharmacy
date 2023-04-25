<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        return response()->json(Auth::user());
    }


    public function store(StoreUserRequest $request)
    {
        //Save User and Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imgName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
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

//        Send Email verification
        $user->sendEmailVerificationNotification();

        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->fill($request->except('email', 'image'));
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imgName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $imgName);

            $oldImage = public_path('/images/') . Auth::user()->image;
            if (file_exists($oldImage)) {
                @unlink($oldImage);
            }
            $user->image = $imgName;
        }
        $user->save();
        return response()->json($user);
    }


    public function destroy(User $user)
    {
        if ($user->orders()->exists()) {
            return response()->json('User Has Orders Can\'t Delete');
        }
        if ($user->image) {
            $oldImage = public_path('/images/') . $user->image;
            if (file_exists($oldImage)) {
                @unlink($oldImage);
            }
        }
        $user->delete();
        return response()->json(['message' => 'User Deleted Successfully']);
    }


}
