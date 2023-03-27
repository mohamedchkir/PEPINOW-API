<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{

    public function index()
    {
        if (auth()->user()->hasPermissionTo('view categories')) {
        $categories = Category::with('plantes')->get();
        return response()->json($categories);
        }else{
            return response()->json([
                'message' => 'You cannot view categories'
            ], 403);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        if (auth()->user()->hasPermissionTo('create categories')) {
            // validate the name using the StoreCategoryRequest
            $validated = $request->validated();
            // create a new category
            $category = Category::create($validated);
            // return the new category
            return response()->json([
                'message' => 'Category created successfully',
                'category' => $category
            ]);}
        else{
            return response()->json([
                'message' => 'You cannot create categories'
            ], 403);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (auth()->user()->hasPermissionTo('view categories')) {
            $category = Category::with('plantes')->findOrFail($category->id);
            if (!$category) {
                # code...
                return response()->json([
                    'message' => 'Category not found'
                ]);
            }
            return response()->json($category);
        }else{
            return response()->json([
                'message' => 'You cannot view categories'
            ], 403);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if (auth()->user()->hasPermissionTo('edit categories')) {
            $validated = $request->validated();
            $category->update($validated);
            return response()->json([
                'message' => 'Category updated successfully',
                'category' => $category
            ]);
        }else{
            return response()->json([
                'message' => 'You cannot edit categories'
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (auth()->user()->hasPermissionTo('delete categories')) {
            $category = Category::findOrFail($category->id);
            if (!$category) {
                return response()->json([
                    'message' => 'Category not found'
                ]);
            }
            $category->delete();
            return response()->json([
                'message' => 'Category deleted successfully'
            ]);
        }else{
            return response()->json([
                'message' => 'You cannot delete categories'
            ], 403);
        }
    }
}
