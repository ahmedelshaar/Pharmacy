<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index( Request $request){
        if($request->ajax()){
            return datatables()->collection( User::withTrashed()->get())->toJson() ;
        }
        return view('admin.users.index');
    }
    public function destroy($id){
        $user = User::where('id',$id)->first();
        if ($user) {
            $user->delete();
            return to_route('users.index');
        }else
            return back()->with('error', 'user not found');
    }
}
