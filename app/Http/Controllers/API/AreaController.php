<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;
use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $area = Area::all();
        return AreaResource::collection($area);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAreaRequest $request)
    {
        $data = $request->all();
        $area = Area::create([
            'name' => $data['name'],
            'country_id' => $data['country_id'],

        ]);

        return new AreaResource($area);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $area = Area::find($id);
        return new AreaResource($area);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAreaRequest $request, string $id)
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json(['message' => 'Area not found'], 404);
        }
    
        $area->name = $request->input('name');
        $area->country_id = $request->input('country_id');
        $area->save();
    
        return response()->json(['area' => $area], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    
            // Find the area record to delete
            $area = Area::find($id);
        
            if (!$area) {
                return response()->json(['message' => 'Area not found'], 404);
            }
        
            // Delete the area record
            $area->delete();
        
            // Return a JSON response with a success message and a 204 No Content status code
            return response()->json(['message' => 'Area deleted successfully'], 204);
        
    }
}
