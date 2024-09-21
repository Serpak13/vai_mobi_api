<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();
        //фильтрация по категории
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        //Фильтрация по минимально цене
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        //Фильтрация по максимальной цене
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        //Сортировка по цене
        if ($request->has('sort_price')) {
            $query->orderBy('price', $request->sort_price);
        }
        //Поиск по названию
        if($request->has('name')){
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $products = $query->paginate(10);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
