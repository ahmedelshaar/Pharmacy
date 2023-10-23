<?php

namespace App\Http\Controllers;

use App\Jobs\SendMail;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderMedicineQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderMedicineQuantityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // orders in my pharmacy that are not delivered
        // ['New', 'Processing', 'Waiting', 'Canceled', 'Confirmed', 'Delivered']
        $orders = Order::where('pharmacy_id', 1)
            ->where('status', 'New')
            ->get();
        return view('orders.index', ['orders' => $orders], compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $order)
    {
        $order = Order::find($order);

        $total_price = 0;
        $medicines = $order->medicines;
        foreach ($medicines as $medicine) {
            $total_price += $medicine->pivot->price * $medicine->pivot->quantity;
        }

        $order->status = 'Waiting';
        $order->doctor_id = Auth::id();
        $order->total_price = $total_price;
        $order->save();

        SendMail::dispatch($order->user, 'invoice', $order);
        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderMedicineQuantity $orderMedicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderMedicineQuantity $orderMedicine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $order)
    {
        $order = Order::find($order);
        $medicine = Medicine::find($request->medicine_id);
        if ($order->medicines()->where('medicine_id', $medicine->id)->exists())
            // increase quantity with the new quantity
            $order->medicines()->updateExistingPivot($medicine->id, ['quantity' => $order->medicines()->where('medicine_id', $medicine->id)->first()->pivot->quantity + $request->quantity]);
        else
            $order->medicines()->attach($medicine->id, ['quantity' => $request->quantity, 'price' => $medicine->price]);
        $order->doctor_id = Auth::id();
        $order->status = "Processing";
        $order->save();
        return redirect()->route('orders.edit', $order->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $order, Request $request)
    {
        $order = Order::find($order);
        $medicine = Medicine::find($request->medicine_id);
        $order->medicines()->detach($medicine->id);
        // send json response
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
