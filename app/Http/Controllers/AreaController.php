<?php

namespace App\Http\Controllers;

use App\Http\Requests\Area\AddAreaRequest;
use App\Http\Requests\Area\EditAreaRequest;
use App\Models\Area;
use App\Models\Country;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        dd(auth()->user()->getAllPermissions(), auth()->user()->getRoleNames(), auth()->user()->hasRole('admin'), auth()->user()->Permissions());
        $areas = Area::first()->paginate(10);
        return view('admin.areas.index', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddAreaRequest $request)
    {
        $area = Area::create($request->all());
        if ($area) {
            return redirect()->route('areas.index')->with('success', 'Area created successfully!');
        } else {
            return back()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.areas.create', compact('countries'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        $countries = Country::all();

        return view('admin.areas.edit', compact('area', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditAreaRequest $request, Area $area)
    {
        if ($area->update($request->all()))
            return redirect()->route('areas.index')->with('success', 'Area Updated Successfully');
        else
            return redirect()->route('areas.index')->with('error', 'Something Went Wrong!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $area = Area::find($id);
        if ($area) {
            $area->delete();
            return redirect()->route('areas.index')->with('success', 'Area Deleted Successfully');
        } else {
            return back()->with('error', 'Area Not Found');
        }
    }
}
