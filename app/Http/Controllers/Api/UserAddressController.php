<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddress\AddUserAddressRequest;
use App\Http\Requests\UserAddress\Api\EditUserAddressRequest;
use App\Http\Resources\UserAddressResource;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends BaseController
{
    /**
     * list all addresses for authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        $userAddresses = UserAddress::where(['user_id'=>$user->id])->paginate(10);
        return $this->sendResponse(UserAddressResource::collection($userAddresses));
    }
    /**
     * Store a newly created address in storage.
     */
    public function store(AddUserAddressRequest $request)
    {
        $userAddress = new UserAddress();
        $userAddress->fill($request->validated());
        $userAddress->user_id = Auth::id();
        $userAddress->save();
        return $this->sendResponse(new UserAddressResource($userAddress),201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $address_id)
    {
        $user_id = Auth::id();
        try {
            $userAddress = UserAddress::where(['id' => $address_id , 'user_id' => $user_id])->firstOrFail();
        }catch (\Exception $exception){
            return $this->sendError('address not found');
        }
            return $this->sendResponse(new UserAddressResource($userAddress));

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(EditUserAddressRequest $request, $address_id)
    {
        $user_id = Auth::id();
        try {
            $user_address = UserAddress::where(['id' => $address_id,'user_id' => $user_id])->firstOrFail();

        }catch (ModelNotFoundException $exception){
            return $this->sendError('user address not found',404);
        }
        $user_address->fill($request->validated());
        $user_address->save();
        if ($user_address->wasChanged())
            return  $this->sendResponse(new UserAddressResource($user_address));
        else return $this->sendResponse('not thing was changed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($address_id)
    {
        try{
        $address = UserAddress::findOrFail($address_id);
        }catch(ModelNotFoundException $exception){
            return $this->sendError('user address not found',404);
        }
        $address = UserAddress::findOrFail($address_id);
        $address->delete();
        return $this->sendResponse('deleted',204);
    }
}
