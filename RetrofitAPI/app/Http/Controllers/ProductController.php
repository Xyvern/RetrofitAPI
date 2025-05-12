<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        $products = Product::all();
        return response()->json($products, 200);
    }

    public function getProductById($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product, 200);
    }

    public function createProduct(Request $request)
    {
        Product::create([
            'name' => $request->input('name'),
            'categoryID' => $request->input('categoryID'),
            'price' => $request->input('price'),
            'rating' => $request->input('rating', 0.00),
            'description' => $request->input('description'),
            'img_url' => $request->input('img_url', '-'),
        ]);
        return response()->json(['message' => 'Product created successfully'], 201);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::withTrashed()->where('productID', $id)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->update([
            'name' => $request->input('name', $product->name),
            'description' => $request->input('description', $product->description),
            'price' => $request->input('price', $product->price),
        ]);
        return response()->json(['message' => 'Product updated successfully'], 200);
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
