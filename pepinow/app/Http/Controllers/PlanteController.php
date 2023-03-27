<?php

namespace App\Http\Controllers;

use App\Models\Plante;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlanteRequest;
use App\Http\Requests\UpdatePlanteRequest;

class PlanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasPermissionTo('view plants')) {
            $plants = Plante::with('category')->get();
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
    public function store(StorePlanteRequest $request)
    {
        if (auth()->user()->hasPermissionTo('create plants')) {
            $validated = $request->validated();
            $validated["user_id"]=auth()->user()->id;
            $plante = Plante::create($validated);
            return response()->json([
                'message' => 'Plant created successfully',
                'plant' => $plante
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
    public function show(Plante $plante)
    {
        if (auth()->user()->hasPermissionTo('view plants')) {

            $plante = Plante::with('category')->find($plante->id);
            return response()->json($plante);
        }else{
            return response()->json([
                'message' => 'You cannot view plants'
            ], 403);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlanteRequest $request, Plante $plante)
    {
        if (auth()->user()->hasPermissionTo('edit plants')) {
            $validated = $request->validated();
            $validated["user_id"]=auth()->user()->id;
            $plante->update($validated);
            return response()->json([
                'message' => 'Plant updated successfully',
                'plant' => $plante
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
    public function destroy(Plante $plante)
    {
        if (auth()->user()->hasPermissionTo('delete plants')) {
            $plante->delete();
            return response()->json([
                'message' => 'Plant deleted successfully',
                'plant' => $plante
            ]);
        }else{
            return response()->json([
                'message' => 'You cannot delete plants'
            ], 403);
        }
    }
}
