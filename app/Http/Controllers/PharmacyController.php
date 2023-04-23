<?php

namespace App\Http\Controllers;

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
        //
        // if ($request->ajax()) {
        //     return datatables()->collection(Pharmacy::with(['area' => function($query) {
        //         $query->select('id', 'name');
        //     }])->get())->toJson();
        // }
        // return view('pharmacy.index');


        $allPharamacies = Pharmacy::all();  //select * from Posts

        return view('pharmacy.index',[
            'pharmacies' => $allPharamacies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $areas = Area::all();
        return view('pharmacy.create',["areas" => $areas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePharmacyRequest $request)
    {
        if($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $imageName = time() . '.' . $avatar ->extension();
            $avatar ->move(public_path('images'), $imageName);
            Pharmacy::create($request->except('_token', 'avatar','area_id') + ['avatar' => $imageName, 'area_id' => $request['area_id']]);
        }else{
        Pharmacy::create([
            'name' => $request['name'],
            'priority' => $request['priority'],
            'area_id' => $request['area_id'],
            'avatar'=>$request['avatar'],
        ]);

        return redirect()->route('pharamacy.index');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Pharmacy $pharmacy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $areas = Area::all();
        $pharmacy = Pharmacy::find($id);
        return view('pharmacy.edit',[
            'pharmacy' => $pharmacy,
            'areas' => $areas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pharmacy $pharmacy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        //soft delete
        $pharmacy = Pharmacy::find($id);
        $pharmacy->delete();
        return redirect()->route('pharamacy.index');


    }

    //restore data after delete
    // public function restore()
    // {
    //     Pharmacy::withTrashed()->restore();
    //     return redirect()->back();
    // }
}