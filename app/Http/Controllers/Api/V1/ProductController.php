<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\V1\ProductResource;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Requests\V1\StoreProductRequest;
use App\Http\Requests\V1\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return $request->user();
        return new ProductCollection(Product::with('productImages')->paginate());
        // return response()->json(Product::with('productImages')->paginate());
    }

    public function test()
    {
        $data = Http::get('https://jsonplaceholder.typicode.com/posts');
        dd($data->json());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $productInfo = json_decode($request->productData, true);
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
                $filename = Storage::put('/product', $image);
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

    // public function edit(Product $product)
    // {
    //     return response()->json($product->catName);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedInfo = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required',
            'old_price' => 'required',
            'description' => 'required',
            'unit' => 'required',
            'category_id' => 'required'
        ])->validated();

        $product->update($validatedInfo);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $user = request()->user();

        if ($user->type != 1) {
            return response()->json(['message' => 'Unauthorized action'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
