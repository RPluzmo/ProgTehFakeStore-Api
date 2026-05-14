<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'required|string',
            'category'    => 'required|string',
            'image'       => 'required|string', // URL vai ceļš
            'rating'      => 'nullable|array', // Jābūt masīvam/JSON
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = Product::create($request->all());

        return response()->json([
            'message' => 'Produkts veiksmīgi izveidots!',
            'product' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'sometimes|string|max:255',
            'price'       => 'sometimes|numeric',
            'description' => 'sometimes|string',
            'category'    => 'sometimes|string',
            'image'       => 'sometimes|string',
            'rating'      => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product->update($request->all());

        return response()->json([
            'message' => 'Produkts veiksmīgi atjaunināts!',
            'product' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Produkts veiksmīgi izdzēsts!'
        ], 200);
    }
}
