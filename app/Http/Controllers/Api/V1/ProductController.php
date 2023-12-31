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
        // return new ProductCollection(Product::with('productImages')->withTrashed()->paginate());
        return response()->json(Product::with('productImages')->withTrashed()->paginate());
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
            return response()->json($validatedInfo->errors(), 422);
        }
        $info = $validatedInfo->validated();
        $info['created_by'] = Auth::user()->id;
        $created_product_instance = Product::create($info);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename    = Storage::put('/product', $image);
                $url = env('APP_URL') . '/storage/' . $filename;
                $created_product_instance->productImages()->create([
                    'path' => $filename,
                    'url' => $url
                ]);
            }
        }
        return new ProductResource($created_product_instance);
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
