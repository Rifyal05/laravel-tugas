<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories; 
use App\Http\Resources\ProductCategoryResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categories::latest()->paginate(10);
        if ($categories->isEmpty()) {
            return new ProductCategoryResource(null, 200, 'No Product Categories found');
        }
        return new ProductCategoryResource($categories, 200, 'List Data Product Category');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:product_categories,slug',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = new Categories;
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('uploads/product_categories', 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return new ProductCategoryResource($category, 201, 'Product Category Created Successfully');
    }

    public function show(Categories $category)
    {
        return new ProductCategoryResource($category, 200, 'Product Category Detail');
    }

    public function update(Request $request, Categories $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:product_categories,slug,' . $category->id,
            'description' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->has('name')) {
            $category->name = $request->name;
        }

        if ($request->has('slug')) {
            $category->slug = $request->slug;
        } elseif ($request->has('name') && $category->name !== $request->name) { //
            $category->slug = Str::slug($request->name);
        }
        
        if ($request->has('description')) {
            $category->description = $request->description;
        }

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $image = $request->file('image');
            $imagePath = $image->store('uploads/product_categories', 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return new ProductCategoryResource($category, 200, 'Product Category Updated Successfully');
    }

    public function destroy(Categories $category)
    {

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();
        return new ProductCategoryResource(null, 200, 'Product Category Deleted Successfully');
    }
}