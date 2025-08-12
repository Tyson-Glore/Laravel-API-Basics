<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductShowResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductIndexResource::collection(Product::with('category')->get());
    }

    public function show(Product $product): ProductShowResource
    {
        return new ProductShowResource($product);
    }

    public function store(StoreProductRequest $request): ProductShowResource
    {
        $product = Product::create($request->validated());

        return new ProductShowResource($product);
    }
}
