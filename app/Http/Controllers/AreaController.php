<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;


class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $area = Area::all();
       // $areas = Area::with('country')->get();
        return view('areas.index', ['area' => $area]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allAreas = Area::all();
        return view('areas.create', [
            'areas' => $allAreas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data= $request->all();
        $item=Area::create([
            'name'=>$data['name'],
            'country_id'=>$data['country_id'],            
        ]);
        return redirect()->route('areas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        return view('areas.edit', ['area' => $area]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        $area->update([
            'name' => $request->name,
            'country_id' => $request->country_id,
        ]);
        return redirect()->route('areas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        $area->delete();
        return redirect()->route('areas.index');
    }
}
