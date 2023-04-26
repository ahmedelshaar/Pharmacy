<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePharmacyRequest;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Models\Area;
use App\http\Requests\StorePharmacyRequest;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         if ($request->ajax()) {
             return datatables()->collection(Pharmacy::with(['area' => function($query) {
                 $query->select('id', 'name');
             }])->get())->toJson();
         }

        return view('pharmacy.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Area::all();
        return view('pharmacy.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePharmacyRequest $request)
    {
        $avatar = $request->file('avatar');
        $imageName = time() . '.' . $avatar ->extension();
        $avatar->move(public_path('images/pharmacies'), $imageName);
        $image = 'images/pharmacies/' . $imageName;
        Pharmacy::create($request->except( 'avatar') + ['avatar' => $image]);
        return redirect()->route('pharmacy.index')->with('success', 'New Pharmacy created Successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Pharmacy $pharmacy)
    {
        return view('pharmacy.show', compact('pharmacy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pharmacy $pharmacy)
    {
        $areas = Area::all();
        return view('pharmacy.edit', compact(['pharmacy', 'areas']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePharmacyRequest $request, Pharmacy $pharmacy)
    {
        $pharmacy->fill($request->except('avatar'));
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $imageName = time() . '.' . $avatar ->extension();
            $avatar ->move(public_path('images/pharmacies'), $imageName);
            $pharmacy->avatar = 'images/pharmacies/' . $imageName;
        }
        $pharmacy->save();
        return redirect()->route('pharmacy.index')->with('success', 'Pharmacy updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
        $pharmacy->delete();
        return redirect()->route('pharmacy.index')->with('success', 'Pharmacy deleted Successfully!');
    }


}
