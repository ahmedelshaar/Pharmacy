<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicineStoreRequest;
use App\Http\Requests\MedicineUpdateRequest;
use App\Models\Doctor;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return datatables()->collection(Medicine::with(['pharmacy' => function($query) {
                $query->select('id', 'name');
            }])->get())->toJson();
        }
        return view('medicine.index');
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
    public function store(MedicineStoreRequest $request)
    {
        Medicine::create($request->all());
        return redirect()->route('medicine.index')->with('success', 'New Medicine created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        return view('medicine.show', compact('medicine'));
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
    public function update(MedicineUpdateRequest $request, Medicine $medicine)
    {
        $medicine->update($request->all());
        return redirect()->route('medicine.index')->with('success', 'Medicine updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('medicine.index')->with('success', 'Medicine deleted successfully');
    }

}




