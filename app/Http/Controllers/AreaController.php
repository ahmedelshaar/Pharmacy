<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaStoreRequest;
use App\Http\Requests\AreaUpdateRequest;
use App\Http\Requests\StoreAreaRequest;
use App\Models\Area;
use Illuminate\Http\Request;
use Webpatser\Countries\Countries;


class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->collection(Area::with(['country' => function($query) {
                $query->select('id', 'name');
            }])->get())->toJson();
        }
        return view('area.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Countries::select('id', 'name')->get();
        return view('area.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaStoreRequest $request)
    {
        Area::create($request->all());
        return redirect()->route('area.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        return view('area.show', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        $countries = Countries::select('id', 'name')->get();
        return view('area.edit', compact('area', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaUpdateRequest $request, Area $area)
    {
        $area->update($request->all());
        return redirect()->route('area.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        $area->delete();
        return redirect()->route('area.index');
    }
}
