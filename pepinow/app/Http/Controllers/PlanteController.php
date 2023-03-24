<?php

namespace App\Http\Controllers;

use App\Models\Plante;
use App\Http\Requests\StorePlanteRequest;
use App\Http\Requests\UpdatePlanteRequest;
use Illuminate\Http\JsonResponse;

class PlanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $plantes = Plante::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Plantes list',
            'data' => $plantes
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): JsonResponse
    {
        $plantes = Plante::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Plantes list',
            'data' => $plantes
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePlanteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlanteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plante  $plante
     * @return \Illuminate\Http\Response
     */
    public function show(Plante $plante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plante  $plante
     * @return \Illuminate\Http\Response
     */
    public function edit(Plante $plante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlanteRequest  $request
     * @param  \App\Models\Plante  $plante
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlanteRequest $request, Plante $plante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plante  $plante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plante $plante)
    {
        //
    }
}
