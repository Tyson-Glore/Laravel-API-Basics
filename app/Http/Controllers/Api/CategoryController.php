<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryIndexResource;
use App\Http\Resources\CategoryShowResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryIndexResource::collection(Category::all());
    }

    public function show(Category $category)
    {
        return new CategoryShowResource($category);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return new CategoryShowResource($category);
    }
}
