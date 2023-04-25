<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
    public function create()
    {
        return view('user.create');
    }

    //store
    public function store(Request $request)
    {
        //
    }

    //show
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    //edit
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    //update
    public function update(Request $request, string $id)
    {
        //
    }

    //destroy
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
        return redirect()->route('user.index')->with('success', 'User Deleted Successfully');
    }
}
