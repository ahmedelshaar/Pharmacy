<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorStoreRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Models\Doctor;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Facades\DataTables;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Doctor::with(['pharmacy' => function ($query) {
                $query->select('id', 'name');
            }])->role('doctor');

            if ($request->has('pharmacy_id')) {
                $query->where('pharmacy_id', $request->pharmacy_id);
            }
            return datatables()->collection($query->get())->toJson();
        }

        return view('doctor.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pharmacies = Pharmacy::all();
        return view('doctor.create', compact('pharmacies'));
    }


    public function show(Doctor $doctor)
    {
        return view('doctor.show', compact('doctor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorStoreRequest $request)
    {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/doctors'), $imageName);
        $image = 'images/doctors/' . $imageName;
        $data = $request->except('image', 'password') + ['image' => $image, 'password' => Hash::make($request->password)];
        $doctor = Doctor::create($data);
        $doctor->assignRole('doctor');
        return redirect()->route('doctor.index')->with('success', 'New Doctor created Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $pharmacies = Pharmacy::all();
        return view('doctor.edit', compact(['doctor', 'pharmacies']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorUpdateRequest $request, Doctor $doctor)
    {
        $doctor->fill($request->except('image', 'password'));
        $doctor->is_banned = $request->is_banned ?? 0;
        if ($request->password) {
            $doctor->password = Hash::make($request->password);
        }
        if ($request->hasFile('image')) {
            if ($doctor->image && file_exists($doctor->image)) {
                unlink($doctor->image);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/doctors'), $imageName);
            $doctor->image = 'images/doctors/' . $imageName;
        }
        $doctor->save();
        return redirect()->route('doctor.index')->with('success', 'Doctor updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return response()->json([
            'success' => true,
            'message' => 'Doctor deleted successfully'
        ]);
    }

}
