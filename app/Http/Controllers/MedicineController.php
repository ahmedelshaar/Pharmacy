<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use DataTable;
class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicine = Medicine::all();
        return view('medicine.index', compact('medicine'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $medicine = Medicine::all();

        $validatedData = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'cost' => 'required|numeric',
        ]);
    
        // create new medicine
        $medicine = new Medicine;
        $medicine->name = $validatedData['name'];
        $medicine->price = $validatedData['price'];
        $medicine->cost = $validatedData['cost'];
    
        if ($medicine->save()) {
            $medicine = Medicine::all();
            return view('medicine.index', compact('medicine'));
            // return response()->json([
            //     'success' => true,
            //     'message' => 'New Medicine created Successfully!'
            // ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create a new Medicine..'
            ]);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        return view('medicine.edit', compact('medicine'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'cost' => 'required|numeric',
        ]);

        $medicine->name = $validatedData['name'];
        $medicine->price = $validatedData['price'];
        $medicine->cost = $validatedData['cost'];

        if ($medicine->save()) {
            return redirect()->route('medicine.index')->with('success', 'Medicine updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update medicine');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        if ($medicine->delete()) {
            return redirect()->route('medicine.index')
                ->with('success', 'Medicine deleted successfully');
        } else {
            return redirect()->route('medicine.index')
                ->with('error', 'Failed to delete medicine');
        }
    }
    
    

}




