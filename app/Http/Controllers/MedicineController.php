<?php

namespace App\Http\Controllers;

use App\Http\Requests\Medicine\StoreMedicineRequest;
use App\Http\Requests\Medicine\UpdateMedicineRequest;
use App\Models\Medicine;
use App\Models\MedicineType;
use Illuminate\Http\Request;


class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->collection(Medicine::with([
                'type:id,name',
            ])->get())->toJson();
        }
        return view('admin.medicines.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = MedicineType::all();
        return view('admin.medicines.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicineRequest $request)
    {
//        dd($request->all());
        $medicine = new Medicine();
        $medicine->name = $request->name;
        $medicine->price = $request->price;
        $medicine->type_id = $request->type_id;
        $medicine->save();
        return redirect()->route('medicines.index')->with('success', 'Item stored successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
//        dd($id);
        $medicine = Medicine::find($id);
        $types = MedicineType::all();
        return view('admin.medicines.edit', ['medicine' => $medicine], compact('medicine', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateMedicineRequest $request)
    {
        $medicine = Medicine::find($id);
        $medicine->name = $request->name;
        $medicine->price = $request->price;
        $medicine->type_id = $request->type_id;
        $medicine->save();
        return redirect()->route('medicines.index')->with('success', 'Item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
//        dd($id);
        $medicine = Medicine::find($id);
//        dd($medicine);
        $medicine->delete();
        return redirect()->route('medicines.index')->with('success', 'Item Deleted successfully!');
    }
}
