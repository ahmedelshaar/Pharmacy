<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Http\Requests\PharmacyRequest;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->collection(Pharmacy::withTrashed()->with(['area' => function ($query) {
                $query->select('id', 'name');
            }])->get())->toJson();
        }
        return view('pharmacies.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Area::all();
        return view('pharmacies.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PharmacyRequest $request)
    {
        $pharmacy = Pharmacy::create($request->all());
        if ($request->hasFile('avatar')) {
            $avatarName = time().'.'.$request->avatar->extension();
            $request->avatar->move('images/pharmacies/', $avatarName);
            $pharmacy->avatar = 'images/pharmacies/' . $avatarName;
        } else {
            $avatarName = null;
        }
        $pharmacy->save();
        return redirect()->route('pharmacies.index')->with('success', 'Pharmacy created successfully!');
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
        $pharmacy = Pharmacy::find($id);
        $areas = Area::all();
        return view('pharmacies.edit', compact( 'pharmacy','areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PharmacyRequest $request, Pharmacy $pharmacy)
    {
        $pharmacy->update($request->except('avatar'));
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $old_avatar = $pharmacy->avatar;
            $avatar = $request->avatar;
            $avatar_new_name = time().'.'.$request->avatar->extension();
            if ($avatar->move('images/pharmacies/', $avatar_new_name)) {
                unlink($old_avatar);
            }
            $pharmacy->avatar = 'images/pharmacies/' . $avatar_new_name;
        }
        $pharmacy->save();
        return redirect()->route('pharmacies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pharmacy = Pharmacy::withTrashed()->find($id);
        if ($pharmacy->trashed()) {
            $pharmacy->forceDelete();
            if ($pharmacy->avatar) {
                unlink($pharmacy->avatar);
            }
        } else {
            $pharmacy->delete();
        }
        return redirect()->route('pharmacies.index');
    }
    public function restore($id)
    {
        $pharmacy = Pharmacy::withTrashed()->find($id);
        $pharmacy->restore();
        return redirect()->route('pharmacies.index');
    }
}
