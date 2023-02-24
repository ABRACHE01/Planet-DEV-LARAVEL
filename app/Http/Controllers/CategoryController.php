<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('index');
        $this->middleware('IsAuthor');
        $this->middleware('IsAdmin');
    }

    public function index()
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name'
        ]);

        $category = Category::create($request->all());

        return new CategoryResource($category);
    }

    
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id
        ]);

        $category->update($request->all());

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
   
    //filter postes by category id

    public function sortcategory(Request $request) {
        $categoryId = $request->query('category_id');
        $sortBy = 'category_id';
        $sortOrder = 'asc';
    
        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json([
                'error' => 'Category not found'
            ], 404);
        }
    
        $articles = $category->articles()->orderBy($sortBy, $sortOrder)->get();
    
        return response()->json([
            'data' => $articles
        ]);
    }
}
