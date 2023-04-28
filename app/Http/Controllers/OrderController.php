<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return datatables()->collection(Order::whereNotNull('pharmacy_id')->with(['user:id,name', 'doctor:id,name', 'pharmacy:id,name'])->get())->toJson();
        }
        return view('order.index');
//        $query = Order::with([
//            'user:id,name',
//            'doctor:id,name',
//            'pharmacy' => function ($query) {
//                $query->select('id', 'name');
//                if (auth()->user()->hasRole('pharmacy')) {
//                    $query->where('id', auth()->user()->pharmacy->id);
//                }
//            }
//        ]);
//
//        if (auth()->user()->hasRole('pharmacy')) {
//            $query->whereHas('pharmacy', function ($query) {
//                $query->where('id', auth()->user()->pharmacy->id);
//            });
//        }
//
//        $query = Order::with(['user' => function ($query) {
//                $query->select('id', 'name');
//            }, 'doctor' => function ($query) {
//                $query->select('id', 'name');
//            }])->with('pharmacy', function ($query) {
//                $query->select('id', 'name');
////                if(auth()->user()->hasRole('owner')){
////                    $query->where('id', auth()->user()->pharmacy->id);
////                }
//            });
//            if ($request->has('pharmacy_id')) {
//                $query->where('pharmacy_id', $request->pharmacy_id);
//            }
//            return datatables()->collection($query->get())->toJson();
////        }
//        return view('order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('order.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request)
    {
        Order::create($request->all());
        return redirect()->route('order.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderUpdateRequest $request, Order $order)
    {
        $order->update($request->all());
        return redirect()->route('order.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully'
        ]);
    }
}
