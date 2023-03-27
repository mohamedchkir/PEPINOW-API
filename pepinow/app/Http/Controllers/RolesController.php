<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasPermissionTo('view roles')) {
            $roles = Role::all();

            return response()->json($roles);
        }else{
            return response()->json([
                'message' => 'You cannot view roles'
            ], 403);
        }
    }

    public function indexWithPermissions()
    {
        if (auth()->user()->hasPermissionTo('view roles')) {
            $roles = Role::with('permissions')->get();
            return response()->json($roles);
        }else{
            return response()->json([
                'message' => 'You cannot view roles'
            ], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->hasPermissionTo('create roles')) {
            $validatedData = $request->validate([
                'name' => 'required|unique:roles,name',
                'description' => 'nullable|string',
            ]);
            $role = Role::create($validatedData);
            return response()->json($role, 201);
        }else{
            return response()->json([
                'message' => 'You cannot create roles'
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (auth()->user()->hasPermissionTo('view roles')) {
            $role = Role::findOrFail($id);
            return response()->json($role);
        }else{
            return response()->json([
                'message' => 'You cannot view roles'
            ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->hasPermissionTo('edit roles')) {
            $role = Role::findOrFail($id);
            $validatedData = $request->validate([
                'name' => 'sometimes|required|unique:roles,name,' . $role->id,
                'description' => 'nullable|string',
            ]);
            $role->update($validatedData);
            return response()->json($role);
        }else{
            return response()->json([
                'message' => 'You cannot edit roles'
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->hasPermissionTo('delete roles')) {
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json(['message' => 'Role deleted successfully']);
        }else{
            return response()->json([
                'message' => 'You cannot delete roles'
            ], 403);
        }
    }

    public function updatePermission(Role $role, Permission $permission)
    {
        if (auth()->user()->hasPermissionTo('grant and revoke permission')) {
            $grant = request()->input('grant');
            if ($grant=="true") {
                $role->givePermissionTo($permission);
                return response()->json([
                    'message' => 'Permission granted successfully.'
                ], 200);
            } else {
                $role->revokePermissionTo($permission);
                return response()->json([
                    'message' => 'Permission revoked successfully.'
                ], 200);
            }
        }else{
            return response()->json([
                'message' => 'You cannot grant and revoke permission'
            ], 403);
        }
    }

}
