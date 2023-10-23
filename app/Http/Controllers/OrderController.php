<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Order;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if role is admin
        if (Auth::user()->hasRole('admin')) {
            if ($request->ajax()) {
                return datatables()->collection(Order::with([
                    'user:id,name',
                    'doctor:id,name',
                    'pharmacy:id,name',
                    'delivering_address:id,street_name,building_number',

                ])->get())->toJson();
            }
        } else {
            if ($request->ajax()) {
                return datatables()->collection(Order::with([
                    'user:id,name',
                    'doctor:id,name',
                    'pharmacy:id,name',
                    'delivering_address:id,street_name,building_number',

                ])->where('pharmacy_id', Auth::user()->pharmacy_id)->get())->toJson();
            }
        }

        return view('admin.orders.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->pharmacy_id = Auth::user()->pharmacy_id;
        $order->doctor_id = $request->doctor_id;
        $order->status = 'Processing';
//        $order->delivering_address_id = User::find($request->user_id)->addresses()->where('is_main', 1)->first()->id;
        $order->delivering_address_id = UserAddress::where('user_id', $request->user_id)->where('is_main', 1)->first();
        if ($order->delivering_address_id == null) {
            return redirect()->route('orders.create')->with('warning', 'User has no main address');
        } else
            $order->delivering_address_id = $order->delivering_address_id->id;
        $order->is_insured = $request->is_insured || 0;
        $order->creation_type = Auth::user()->getRoleNames()->first();

        $order->save();


        return redirect()->route('orders.edit', $order->id);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.orders.create', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $order, Request $request)
    {
        // not new or processing
        $order = Order::find($order);
        $status = $order->status;
        if (!in_array($status, ['New', 'Processing'])) {
            return redirect()->route('orders.index')->with('warning', "You can not edit {$status} order");
        }
        if ($request->ajax()) {
//            return datatables()->collection($order->medicines()->withPivot('quantity', 'price')->get())->toJson();
            // medicine for order with it's quantity and price and type name
            return datatables()->collection($order->medicines()->withPivot('quantity', 'price')->get())->addColumn('type', function ($medicine) {
                return $medicine->type->name;
            })->toJson();

        }
        $medicines = Medicine::all();
        return view('admin.orders.edit', compact('order', 'medicines'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($order)
    {
        $order = Order::find($order);
        if (!in_array($order->status, ['New', 'Processing'])) {
            return redirect()->route('orders.index')->with('warning', "You can not Cancel {$order->status} order");
        }
        $order->status = 'Canceled';
        $order->save();
        return redirect()->route('orders.index');
    }
}
