<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //index
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->collection(User::all())->toJson();
        }
        return view('user.index');
    }

    //create

    public function store(StoreUserRequest $request)
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
            'image' => '/images/users/' . $imgName,
            'national_id' => $request->national_id,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'last_login' => now(),
        ]);
        $user->sendEmailVerificationNotification();
        return redirect()->route('user.index')->with('success', 'User Created Successfully');
    }

    //store

    public function create()
    {
        return view('user.create');
    }

    //show

    public function show(User $user)
    {
        if (request()->ajax()) {
            return datatables()->collection($user->adresses()->with(['area' => function ($query) {
                $query->select('id', 'name');
            }])->get())->toJson();
        }
        return view('user.show', compact('user'));
    }

    //edit
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    //update
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->fill($request->except('image', 'email', 'password'));
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imgName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/users');
            $image->move($destinationPath, $imgName);
            if (file_exists(public_path($user->image))) {
                @unlink(public_path($user->image));
            }
            $user->image = '/images/users/' . $imgName;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('user.index')->with('success', 'User Updated Successfully');
    }

    //destroy
    public function destroy(User $user)
    {
        if ($user->orders()->exists()) {
            return redirect()->route('user.index')->with('error', 'User has orders can\'t delete');
        }
        if (file_exists(public_path($user->image))) {
            @unlink(public_path($user->image));
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User Deleted Successfully');
    }
}
