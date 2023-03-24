<?php

namespace App\Http\Controllers;

use App\Models\Plante;
use App\Http\Requests\StorePlanteRequest;
use App\Http\Requests\UpdatePlanteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
    public function store(StorePlanteRequest $request): JsonResponse
    {
        // generate random name for the image
        $random = rand(0, 100000);
        $imageName = "Image" . date('ymd') . $random .'.'.$request->image->extension();

        // store the image in storage folder storage/app/public/plantes/images
        $request->image->storeAs("public/plantes/images", $imageName);

        // override the new name of image to request before storing in database
        $product_array = $request->all();
        $product_array["image"] = $imageName;
        $product_array["user_id"] = Auth::user()->id;

//        dd($product_array);

        $product = Plante::create($product_array);

        return response()->json([
            "status" => "success",
            "message" => "product created successfully",
            "data" => $product,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plante  $plante
     * @return \Illuminate\Http\Response
     */
    public function show(Plante $plante): JsonResponse
    {
        //
        $plante->category;
        return response()->json([
            'status' => 'success',
            'message' => 'Plante details',
            'data' => $plante
        ]);

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
    public function update(UpdatePlanteRequest $request, Plante $plante): JsonResponse
    {
        $plante->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Plante updated successfully',
            'data' => $plante
        ]);


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
        $plante->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Plante deleted successfully',
            'data' => $plante
        ]);
    }
}
