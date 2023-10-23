<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->hasRole('admin')) {
            if ($request->ajax()) {
                // return data table with all pharmacies revenue data including total orders and total sales
                return datatables()->collection(Pharmacy::all())
                    ->addColumn('total_orders', function ($data) {
                        return $data->orders->count();
                    })->addColumn('total_sales', function ($data) {
                        return $data->orders->sum('total_price');
                    })->addColumn('action', function ($data) {
                        $button = '<a href="' . route('revenue.show', $data->id) . '" name="show" id="' . $data->id . '" class="show btn btn-primary btn-sm">Show</a>';
                        return $button;
                    })->rawColumns(['action'])->make(true);
            }
        } else {
            return redirect()->route('revenue.show', Auth::user()->pharmacy_id);
        }
        return view('admin.revenue.index');
    }

    public function show($id)
    {

        $pharmacy = Pharmacy::findOrFail($id);
        $orders = $pharmacy->orders;
        $total_orders = $orders->count();
        $total_sales = $orders->sum('total_price');
        return view('admin.revenue.show', compact('pharmacy', 'total_orders', 'total_sales'));
    }

}
