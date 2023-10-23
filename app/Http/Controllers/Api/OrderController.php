<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderPrescriptions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends BaseController
{
    /**
     * list all orders for authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders;
        return $this->sendResponse(OrderResource::collection($orders));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $user = Auth::user();
        $order = new Order();
        $prescriptions = $request->validated('prescription');
        $order->user_id = $user->id;
        $order->is_insured = $request->is_insured;
        $order->delivering_address_id = $request->delivering_address_id;
        $order->status = "New";
        $order->save();
        $this->StorePrescription($prescriptions,$order->id);
        return $this->sendResponse(new OrderResource($order));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $orderId)
    {
        try {
            $order = Order::where(['id' => $orderId,'user_id' => Auth::id()])->firstorFail();
        }catch(\Exception $exception){
            return $this->sendError('this order does not exist',404);
        }
        return $this->sendResponse(new OrderResource($order));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $order_id)
    {
        $user_id = Auth::id();
        try {
            $order = Order::where(['id' => $order_id,'user_id' => $user_id])->firstOrFail();
        }catch (\Exception $exception){
            return $this->sendError('this order does not exist',404);
        }
        $data = array_replace($order->toArray(), $request->all());
        $order->update(['is_insured' => $data['is_insured'],'delivering_address_id'=>$data['delivering_address_id']]);
        $order->save();
        if($request->hasFile('prescription')){
            $prescriptions = $request->validated('prescription');
            $this->deletePrescription($order->id);
            $this->storePrescription($prescriptions,$order->id);
        }
            return $this->sendResponse(new OrderResource($order),204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    private function StorePrescription ($prescriptions, $order_id) {
        foreach ($prescriptions as $prescription) {
            $prescriptionName = time() .'-'.$prescription->getClientOriginalName();
            $prescriptionPath = $prescription->storeAs('public/prescription_images', $prescriptionName);
            $orderPrescription = new OrderPrescriptions([
                'image' => $prescriptionName,
                'order_id' => $order_id
            ]);
            $orderPrescription->save();
        }
    }
    private  function isPrescriptionUpdated($prescriptions){
        foreach ($prescriptions as $pres){
            if ($pres->wasChanged()) return true;
        }
        return false;
    }
    private function deletePrescription($order_id) {
        $prescriptions = OrderPrescriptions::where("order_id", $order_id)->get();
        foreach ($prescriptions as $prescription) {
            $imagePath = 'prescription_images/'.$prescription->prescription;
            Storage::delete($imagePath);
        }
        OrderPrescriptions::where("order_id", $order_id)->delete();
    }
}
