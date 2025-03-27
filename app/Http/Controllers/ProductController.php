<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get product by ID.
     */
    public function getProductByID($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                "data" => "",
                "status" => "404",
                "message" => "Product not found"
            ], 404);
        }
        
        return response()->json([
            "data" => $product,
            "status" => "200",
            "message" => "success"
        ]);
    }

    /**
     * Add new product.
     */
    public function addProduct(Request $request)
    {
        $product = Product::create($request->all());
        
        return response()->json([
            "data" => "",
            "status" => "200",
            "message" => "success"
        ]);
    }

    /**
     * Update product by ID.
     */
    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                "data" => "",
                "status" => "404",
                "message" => "Product not found"
            ], 404);
        }
        
        $product->update($request->all());
        
        return response()->json([
            "data" => "",
            "status" => "200",
            "message" => "success"
        ]);
    }

    /**
     * Add quantity to product by ID.
     */
    public function addQuantityProduct(Request $request, $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                "data" => "",
                "status" => "404",
                "message" => "Product not found"
            ], 404);
        }
        
        $product->increment('quantity', $request->quantity);
        
        return response()->json([
            "data" => "",
            "status" => "200",
            "message" => "success"
        ]);
    }

    /**
     * Deduct quantity from product by ID.
     */
    public function deductQuantityProduct(Request $request, $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                "data" => "",
                "status" => "404",
                "message" => "Product not found"
            ], 404);
        }
        
        if ($product->quantity < $request->quantity) {
            return response()->json([
                "data" => "",
                "status" => "400",
                "message" => "Insufficient stock"
            ], 400);
        }
        
        $product->decrement('quantity', $request->quantity);
        
        return response()->json([
            "data" => "",
            "status" => "200",
            "message" => "success"
        ]);
    }
}
