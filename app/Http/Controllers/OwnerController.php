<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;


class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->collection(Doctor::with([
                'doctor:id,name',
            ])->role('owner')->get())->toJson();
        }

        return view('owners.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owners.create');
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
            'email' => 'required|email|unique:doctors,email',
            'password' => 'required',
        ]);

        $owner = new Doctor;
        $owner->national_id = $request->national_id;
        $owner->name = $request->name;
        $owner->pharmacy_id = $request->pharmacy_id;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);

        if ($request->has('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save(public_path('images/owners' . $filename));
            $owner->image = 'images/owners' . $filename;
        }

        $owner->save();
        $owner->assignRole('owner');

        return redirect()->route('owners.index')->with('success', 'Owner created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $owner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $owner = Doctor::find($id);
        return view('owners.edit', compact('owner'));
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

        $owner = Doctor::find($id);
        $owner->national_id = $request->national_id;
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->pharmacy_id = $request->pharmacy_id;
        if ($request->filled('password')) {
            $owner->password = Hash::make($request->password);
        }

        if ($request->has('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save(public_path('images/owners/' . $filename));
            $owner->image = 'images/owners/' . $filename;
        }

        $owner->save();

        return redirect()->route('owners.index')->with('success', 'Owner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $owner = Doctor::find($id);
        // Delete the image file associated with the doctor (if it exists)
        if ($owner->image && file_exists(public_path($owner->image))) {
            unlink(public_path($owner->image));
        }

        // Delete the doctor record from the database
        $owner->delete();

        return redirect()->route('owners.index')->with('success', 'Owner deleted successfully.');
    }

    public function ban($id)
    {
        $owner = Doctor::findOrFail($id);
        $owner->is_banned = true;
        $owner->banned_at = now('UTC'); // set the banned_at attribute to the current timestamp in UTC timezone
        $owner->banned_at = now()->format('Y-m-d H:i:s'); // set the banned_at attribute to the current timestamp in a specific format
        $owner->save();

        return redirect()->route('owners.index');
    }

    public function unban($id)
    {
        $owner = Doctor::findOrFail($id);
        $owner->is_banned = false;
        $owner->save();

        return redirect()->route('owners.index');
    }
}
