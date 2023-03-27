<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasPermissionTo('view permissions')) {
            $permissions = Permission::all();
            return response()->json($permissions);
        }else{
            return response()->json([
                'message' => 'You cannot view permission'
            ], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->hasPermissionTo('create permissions')) {
            $validatedData = $request->validate([
                'name' => 'required|unique:permissions,name',
                'description' => 'nullable|string',
            ]);
            $permission = Permission::create($validatedData);
            return response()->json($permission, 201);
        }else{
            return response()->json([
                'message' => 'You cannot create permission'
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (auth()->user()->hasPermissionTo('view permissions')) {
            $permission = Permission::findOrFail($id);
            return response()->json($permission);
        }else{
            return response()->json([
                'message' => 'You cannot view permission'
            ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->hasPermissionTo('edit permissions')) {
            $permission = Permission::findOrFail($id);
            $validatedData = $request->validate([
                'name' => 'sometimes|required|unique:permissions,name,' . $permission->id,
                'description' => 'nullable|string',
            ]);
            $permission->update($validatedData);
            return response()->json($permission);
        }else{
            return response()->json([
                'message' => 'You cannot edit permission'
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->hasPermissionTo('delete permissions')) {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            return response()->json(['message' => 'Permission deleted successfully']);
        }else{
            return response()->json([
                'message' => 'You cannot delete permissions'
            ], 403);
        }
    }
}
