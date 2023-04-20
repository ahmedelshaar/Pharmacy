<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        //Get All Users
        $users = User::paginate(10);
//        $users = User::all();
        return response()->json($users);
    }

    public function show(string $id)
    {
        //User By ID
        $user = User::find($id);
        if (!$user) {
            return response()->json('User Not Found');
        }
        return response()->json($user);
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


    public function update(UpdateUserRequest $request, string $id)
    {
        return $request;
        //Update User given data
        $user = User::find($id);
        if (!$user) {
            return response()->json('User Not Found');
        }
        if ($request->hasFile('image')) {
            $oldImage = public_path('/images/') . $user->image;
            $image = $request->file('image');
            $imgName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $imgName);
//          Update User Image
            $user->update($request->except('image') + ['image' => $imgName]);


//          Delete Old Image
            if (file_exists($oldImage)) {
                @unlink($oldImage);
            }
        } else {
            $user->update($request->all());
        }
        return response()->json($user);
    }


    public function destroy(string $id)
    {
        $user = User::find($id);
//        If User Not Found
        if (!$user) {
            return response()->json('User Not Found');
        }
//        if User has Orders
        if ($user->orders()->exists()) {
//            return response()->json($user->orders);
            return response()->json('User Has Orders Can\'t Delete');
        }
//        If User has Image Delete it
        if ($user->image) {
            $oldImage = public_path('/images/') . $user->image;
            if (file_exists($oldImage)) {
                @unlink($oldImage);
            }
        }
        $user->delete();
        return response()->json('User Deleted Successfully');
    }

//    Register
    public function register(StoreUserRequest $request)
    {

    }

}
