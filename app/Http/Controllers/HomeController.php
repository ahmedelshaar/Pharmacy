<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('admin.dashboard');
    }


    public function dashboard()
    {
        $users = User::select(DB::raw("COUNT(*) as count"), 'gender')
            ->groupBy('gender')
            ->get()
            ->pluck('count', 'gender');

        $users = [
            'labels' => $users->keys(),
            'data' => $users->values()
        ];
        return view('admin.dashboard', compact('users'));
    }
}
