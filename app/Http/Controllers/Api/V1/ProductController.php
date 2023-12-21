<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\V1\ProductResource;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Requests\V1\StoreProductRequest;
use App\Http\Requests\V1\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProductCollection(Product::withTrashed()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $productInfo =  json_decode($request->productData, true);
        $validatedInfo = Validator::make($productInfo, [
            'title' => 'required',
            'price' => 'required',
            'old_price' => 'required',
            'description' => 'required',
            'unit' => 'required',
            'category_id' => 'required'
        ]);

        if ($validatedInfo->fails()) {
            return $validatedInfo->errors();
        }
        $info = $validatedInfo->validated();
        $info['created_by'] = Auth::user()->id;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename    = Storage::put('/product', $image);
            }
        }
        return new ProductResource(Product::create($info));
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
        return $product->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return $product->delete();
    }
}
