<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->collection(User::all())->toJson();
        }
        return view('user.index');
    }

    public function store(StoreUserRequest $request)
    {
        $image = $request->file('image');
        $imgName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/users'), $imgName);
        $image = 'images/users/' . $imgName;
        $request->merge(['password' => Hash::make($request->password), 'image' => $image]);
        $user = User::create($request->all());
        $user->sendEmailVerificationNotification();
        return redirect()->route('user.index')->with('success', 'User Created Successfully');
    }

    public function create()
    {
        return view('user.create');
    }

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
        $user->fill($request->except('image', 'password'));
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
        if (file_exists(public_path($user->image))) {
            @unlink(public_path($user->image));
        }
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Pharmacy deleted successfully'
        ]);
    }
}
