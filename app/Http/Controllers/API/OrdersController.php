<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\OrderStoreRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index()
    {
        if (Auth::user()->orders->isEmpty()) {
            return response()->json(['message' => 'You have no orders yet']);
        }
        $orders = Auth::user()->orders;
        $orders->makeHidden(['user_id', 'doctor_id', 'pharmacy_id', 'address_id']);
        $orders->load(['pharmacy:id,name', 'address']);
        return response()->json(['data' => $orders]);
    }

    public function store(OrderStoreRequest $request)
    {
        $prescriptions = [];
        foreach ($request->prescription as $key => $image) {
            $image = $request->file('prescription.' . $key);
            $image_name = time() . $key . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/prescriptions'), $image_name);
            $prescriptions[] = $image_name;
        }
        $request->merge(['user_id' => Auth::id()]);
        Auth::user()->orders()->create($request->except('prescription') + ['prescription' => $prescriptions]);
        return response()->json(['message' => 'Order created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if ($order->user_id != Auth::id()) {
            return response()->json(['message' => 'You can not view this order'], 403);
        }
        $order->makeHidden(['user_id', 'doctor_id', 'pharmacy_id', 'address_id']);
        $order->load(['pharmacy:id,name', 'address']);
        return response()->json(['data' => $order]);
    }

    public function cancel(Order $order)
    {
        if ($order->status != 'Waiting') {
            return response()->json(['message' => 'You can not cancel this order'], 403);
        }
        $order->update(['status' => 'Canceled']);
        return response()->json(['message' => 'Order cancelled successfully']);
    }

    public function confirm(Order $order)
    {
        if ($order->status != 'Waiting') {
            return response()->json(['message' => 'You can not confirm this order'], 403);
        }
        $order->update(['status' => 'Confirmed']);
        return response()->json(['message' => 'Order confirmed successfully']);
    }
}
