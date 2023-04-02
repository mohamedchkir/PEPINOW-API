<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlantRequest;
use App\Http\Requests\UpdatePlantRequest;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasPermissionTo('view plants')) {
            $plants = Plant::with('category')->get();
            return response()->json($plants);
        }else{
            return response()->json([
                'message' => 'You cannot view plants'
            ], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlantRequest $request)
    {
        if (auth()->user()->hasPermissionTo('create plants')) {
            $validated = $request->validated();
            $validated["user_id"]=auth()->user()->id;
            $plant = Plant::create($validated);
            return response()->json([
                'message' => 'Plant created successfully',
                'plant' => $plant
            ]);
        }else{
            return response()->json([
                'message' => 'You cannot create plants'
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Plant $plant)
    {
        if (auth()->user()->hasPermissionTo('view plants')) {

            $plant = Plant::with('category')->find($plant->id);
            return response()->json($plant);
        }else{
            return response()->json([
                'message' => 'You cannot view plants'
            ], 403);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlantRequest $request, Plant $plant)
    {
        if (auth()->user()->hasPermissionTo('edit plants')) {
            $validated = $request->validated();
            $validated["user_id"]=auth()->user()->id;
            $plant->update($validated);
            return response()->json([
                'message' => 'Plant updated successfully',
                'plant' => $plant
            ]);
        }else{
            return response()->json([
                'message' => 'You cannot edit plants'
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plant $plant)
    {
        if (auth()->user()->hasPermissionTo('delete plants')) {
            $plant->delete();
            return response()->json([
                'message' => 'Plant deleted successfully',
                'plant' => $plant
            ]);
        }else{
            return response()->json([
                'message' => 'You cannot delete plants'
            ], 403);
        }
    }
}
