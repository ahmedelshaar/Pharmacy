<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePharmacyRequest;
use App\Models\Doctor;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Models\Area;
use App\http\Requests\PharmacyStoreRequest;

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
             }, 'owner' => function($query) {
                 $query->select('id', 'name', 'pharmacy_id');
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
    public function store(PharmacyStoreRequest $request)
    {
        $avatar = $request->file('avatar');
        $imageName = time() . '.' . $avatar ->extension();
        $avatar->move(public_path('images/pharmacies'), $imageName);
        $image = 'images/pharmacies/' . $imageName;
        $pharmacy = Pharmacy::create($request->except( 'avatar') + ['avatar' => $image]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images/doctors'), $imageName);
        $image = 'images/doctors/' . $imageName;
        $doctor = Doctor::create([
            'name' => $request->doctor_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $image,
            'national_id' => $request->national_id,
            'pharmacy_id' => $pharmacy->id,
        ]);
        $doctor->assignRole('owner');
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

        $pharmacy->fill($request->except('avatar', 'image', 'password'));
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $imageName = time() . '.' . $avatar ->extension();
            $avatar ->move(public_path('images/pharmacies'), $imageName);
            if($pharmacy->avatar != null && file_exists(public_path($pharmacy->avatar))){
                unlink(public_path($pharmacy->avatar));
            }
            $pharmacy->avatar = 'images/pharmacies/' . $imageName;
        }
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/doctors'), $imageName);
            if($pharmacy->owner->image != null && file_exists(public_path($pharmacy->owner->image))){
                unlink(public_path($pharmacy->owner->image));
            }
            $pharmacy->owner->image = 'images/doctors/' . $imageName;
        }
        if($request->has('password')){
            $pharmacy->owner->password = bcrypt($request->password);
        }
        $pharmacy->owner->name = $request->doctor_name;
        $pharmacy->owner->email = $request->email;
        $pharmacy->owner->national_id = $request->national_id;
        $pharmacy->owner->save();
        $pharmacy->save();
        return redirect()->route('pharmacy.index')->with('success', 'Pharmacy updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
        $pharmacy->delete();
        return response()->json([
            'success' => true,
            'message' => 'Pharmacy deleted successfully'
        ]);
    }


}
