<?php

namespace App\Http\Controllers;


use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;


class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // doctors with rule doctor
        if ($request->ajax()) {
            return datatables()->collection(Doctor::with([
                'doctor:id,name',
            ])->role('doctor')->get())->toJson();
        }
        return view('doctors.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'national_id' => 'required|unique:doctors,national_id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:doctors|unique:admins,,email',
            'password' => 'required',
        ]);

        $doctor = new Doctor;
        $doctor->national_id = $request->national_id;
        $doctor->name = $request->name;
        $doctor->pharmacy_id = Auth::user()->pharmacy_id || $request->pharmacy_id;
        $doctor->email = $request->email;
        $doctor->password = Hash::make($request->password);

        if ($request->has('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save(public_path('images/doctors' . $filename));
            $doctor->image = 'images/doctors' . $filename;
        }

        $doctor->save();
        $doctor->assignRole('doctor');

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $doctor = Doctor::find($id);
        return view('doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'national_id' => 'required|unique:doctors,national_id,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:doctors,email,' . $id,
            'password' => 'nullable',
        ]);

        $doctor = Doctor::find($id);
        $doctor->national_id = $request->national_id;
        $doctor->name = $request->name;
        $doctor->email = $request->email;
        $doctor->pharmacy_id = $request->pharmacy_id;
        if ($request->filled('password')) {
            $doctor->password = Hash::make($request->password);
        }

        if ($request->has('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save(public_path('images/doctors/' . $filename));
            $doctor->image = 'images/doctors/' . $filename;
        }

        $doctor->save();

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {

        $doctor = Doctor::find($id);
        if ($doctor->image && file_exists(public_path($doctor->image))) {
            unlink(public_path($doctor->image));
        }
//        dd($medicine);
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor Deleted successfully!');
    }


    public function ban($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->is_banned = true;
        $doctor->banned_at = now('UTC'); // set the banned_at attribute to the current timestamp in UTC timezone
        $doctor->banned_at = now()->format('Y-m-d H:i:s'); // set the banned_at attribute to the current timestamp in a specific format
        $doctor->save();

        return redirect()->route('doctors.index');
    }

    public function unban($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->is_banned = false;
        $doctor->save();

        return redirect()->route('doctors.index');
    }
}
