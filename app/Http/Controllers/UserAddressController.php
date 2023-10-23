<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddress\AddUserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = UserAddress::first()->paginate(10);
        if($addresses) {
            return view('admin.addresses.index', compact('addresses'));
        }else{
            return back()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddUserAddressRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserAddress $userAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserAddress $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAddress $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $address = UserAddress::find($id);
        if($address){
            $address->delete();
            return redirect()->route('addresses.index')->with('success', 'Address Deleted Successfully');
        }else{
            return back()->with('error', 'Area Not Found');
        }
    }
}
