<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDoctorFormRequest;
use App\Models\Doctor;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $doctors = Doctor::query();

        if ($request->ajax()) {
            return DataTables::of($doctors)
                ->addColumn('action', function ($doctor) {
                    $editUrl = route('doctor.edit', $doctor->id);
                    $deleteUrl = route('doctor.destroy', $doctor->id);
                    $deleteBtn = '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-'.$doctor->id.'"><i class="fas fa-trash"></i></button>';
                    $editBtn = '<a href="'.$editUrl.'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
                    return $editBtn.$deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $doctors = $doctors->get(); // execute the query to fetch the doctors

        return view('doctor.index', ['doctors' => $doctors]);
    }

    /* Display Pharmacies Owners
    public function indexOwners()
    {
        $allDoctors = Doctor::where('role', '=', 'pharmacy_owner')->paginate(10);
        return view('doctor.index', [
            'doctors' => $allDoctors,
        ]);
    }
    */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allPharmacies = Pharmacy::all();
        return view('doctor.create', [
            'pharmacies' => $allPharmacies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDoctorFormRequest $request)
    {
        $doctor = Doctor::create($request->all());
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/doctors'), $imageName);
            $doctor->image = 'images/doctors/' . $imageName;
        }
        if ($doctor) {
            $doctor->save();
            return redirect()->route('doctor.index')->with('success', 'New Doctor created Successfully!');
        } else {
            return back()->with('error', 'Failed to create a new Doctor..');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $pharmacies = Pharmacy::all();
        return view('doctor.edit', [
            'doctor' => $doctor,
            'pharmacies' => $pharmacies,
            'current_image' => $doctor->image, // pass the current image path to the view
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $doctor->update($request->except('image'));
        if ($request->hasFile('image')) {
            $oldImagePath = basename($doctor->image); // get the old image file name
            if ($oldImagePath && file_exists('images/doctors/'.$oldImagePath)) {
                unlink('images/doctors/'.$oldImagePath); // delete the old image if it exists
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/doctors'), $imageName);
            $doctor->image = 'images/doctors/' . $imageName;
        }

        $doctor->save();
        return redirect()->route('doctor.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $deletedDoctor = Doctor::destroy($doctor->getKey());
        return redirect()->route('doctor.index');
    }

    public function data(){
        return datatables()->collection(Doctor::all())->toJson();
    }
}
