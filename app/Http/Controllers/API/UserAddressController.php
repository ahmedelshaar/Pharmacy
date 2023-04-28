<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserAddressStoreRequest;
use App\Http\Requests\API\UserAddressUpdateRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses;
        $addresses->makeHidden(['user_id', 'area_id']);
        $addresses->load('area:id,name');
        return $addresses;
    }

    public function store(UserAddressStoreRequest $request)
    {
        $user = auth()->user();
        if($user->addresses()->count() == 0) {
            $request->merge(['is_main' => true]);
        }
        if($request->is_main) {
            $user->addresses()->update(['is_main' => false]);
        }
        $user->addresses()->create($request->all());
        return response()->json(['message' => 'Address created successfully']);
    }

    public function update(UserAddressUpdateRequest $request, UserAddress $userAddress)
    {
        if($request->is_main) {
            auth()->user()->addresses()->update(['is_main' => false]);
        }
        $userAddress->update($request->all());
        return response()->json(['message' => 'Address updated successfully']);
    }
    public function destroy(UserAddress $userAddress)
    {
        if ($userAddress->is_main) {
            return response()->json(['message' => 'You can not delete your main address'], 403);
        }
        $userAddress->delete();
        return response()->json(['message' => 'Address deleted successfully']);
    }
}
