<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\categories;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = categories::all();
        return response()->json($categories);
    }
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'type' => 'required|in:income,expense',
    //     ]);

    //     $category = categories::create([
    //         'name' => $request->name,
    //         'type' => $request->type,
    //     ]);
    //     return back();
    // }

    public function update(Request $request, $id)
    {
        $category = categories::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->update($request->all());
        return response()->json(['category' => $category, 'message' => 'Category updated successfully!']);
    }
    public function destroy($id)
    {
        $category = categories::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted successfully!']);
    }
}
