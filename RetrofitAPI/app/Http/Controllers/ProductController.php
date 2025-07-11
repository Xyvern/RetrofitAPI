<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Rating;
use Termwind\Components\Raw;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        $products = Product::with(['category', 'ratings'])->get()->map(function ($product) {
            return [
                'productID' => $product->productID,
                'name' => $product->name,
                'categoryID' => $product->categoryID,
                'price' => $product->price,
                'rating' => $product->rating,
                'description' => $product->description,
                'img_url' => $product->img_url,
                'fat' => $product->fat,
                'calories' => $product->calories,
                'protein' => $product->protein,
                'deleted_at' => $product->deleted_at,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'category' => $product->category,
                'total_rating' => $product->getTotalRating(), 
            ];
        });

        return response()->json($products, 200);
    }

    public function getTopMenus()
    {
        $products = Product::with(['category', 'ratings'])
            ->orderByDesc('rating')
            ->limit(4)
            ->get();
        
        $formattedProducts = $products->map(function ($product) {
            return [
                'productID' => $product->productID,
                'name' => $product->name,
                'categoryID' => $product->categoryID,
                'price' => $product->price,
                'rating' => $product->rating,
                'description' => $product->description,
                'img_url' => $product->img_url,
                'fat' => $product->fat,
                'calories' => $product->calories,
                'protein' => $product->protein,
                'deleted_at' => $product->deleted_at,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'category' => $product->category,
                'total_rating' => $product->getTotalRating(),
            ];
        });

        return response()->json($formattedProducts, 200);
    }
    // public function getTopMenus() {
    //     try {
    //         Log::info('Starting getTopMenus query');

    //         $products = Product::with(['category', 'ratings'])
    //             ->leftJoin('ratings', 'products.productID', '=', 'ratings.productID')
    //             ->select(
    //                 'products.productID',
    //                 'products.name',
    //                 'products.categoryID',
    //                 'products.price',
    //                 'products.description',
    //                 'products.img_url',
    //                 'products.fat',
    //                 'products.calories',
    //                 'products.protein',
    //                 'products.deleted_at',
    //                 'products.created_at',
    //                 'products.updated_at',
    //                 DB::raw('COALESCE(AVG(ratings.rating), 0) as ratings_avg_rating')
    //             )
    //             ->groupBy(
    //                 'products.productID',
    //                 'products.name',
    //                 'products.categoryID',
    //                 'products.price',
    //                 'products.description',
    //                 'products.img_url',
    //                 'products.fat',
    //                 'products.calories',
    //                 'products.protein',
    //                 'products.deleted_at',
    //                 'products.created_at',
    //                 'products.updated_at'
    //             )
    //             ->orderByDesc('ratings_avg_rating')
    //             ->limit(4)
    //             ->get();

    //         Log::info('Query executed, found ' . $products->count() . ' products');

    //         $formattedProducts = $products->map(function ($product) {
    //             try {
    //                 return [
    //                     'productID' => $product->productID,
    //                     'name' => $product->name,
    //                     'categoryID' => $product->categoryID,
    //                     'price' => $product->price,
    //                     'rating' => $product->rating,
    //                     'description' => $product->description ?? '',
    //                     'img_url' => $product->img_url ?? '',
    //                     'fat' => $product->fat ?? 0,
    //                     'calories' => $product->calories ?? 0,
    //                     'protein' => $product->protein ?? 0,
    //                     'deleted_at' => $product->deleted_at,
    //                     'created_at' => $product->created_at,
    //                     'updated_at' => $product->updated_at,
    //                     'category' => $product->category ? [
    //                         'categoryID' => $product->category->categoryID,
    //                         'name' => $product->category->name ?? '',
    //                     ] : null,
    //                     'total_rating' => $product->getTotalRating(),
    //                 ];
    //             } catch (\Exception $e) {
    //                 Log::error('Error mapping product ID ' . $product->productID . ': ' . $e->getMessage());
    //                 return ['error' => 'Failed to process product'];
    //             }
    //         });

    //         Log::info('Mapping completed, returning response');
    //         return response()->json($formattedProducts, 200);
    //     } catch (\Exception $e) {
    //         Log::error('Error in getTopMenus: ' . $e->getMessage());
    //         return response()->json(['error' => 'Internal server error'], 500);
    //     }
    // }

    public function getProductById($id)
    {
        $product = Product::with('category')->find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        $newProduct = [
            'productID' => $product->productID,
            'name' => $product->name,
            'categoryID' => $product->categoryID,
            'price' => $product->price,
            'rating' => $product->rating,
            'description' => $product->description,
            'img_url' => $product->img_url,
            'deleted_at' => $product->deleted_at,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
            'category' => $product->category,
            'total_rating' => $product->getTotalRating(),
            'protein' => $product->protein,
            'fat' => $product->fat,
            'calories' => $product->calories,
        ];
        
        return response()->json($newProduct, 200);
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
            'fat' => $request->input('fat', 0),
            'calories' => $request->input('calories', 0),
            'protein' => $request->input('protein', 0),
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

    public function getProductsByCategoryName($categoryName)
    {
        $category = Category::where('name', $categoryName)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $products = Product::with(['category', 'ratings'])->where('categoryID', $category->categoryID)->get()->map(function ($product) {
            return [
                'productID' => $product->productID,
                'name' => $product->name,
                'categoryID' => $product->categoryID,
                'price' => $product->price,
                'rating' => $product->rating,
                'description' => $product->description,
                'img_url' => $product->img_url,
                'deleted_at' => $product->deleted_at,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'category' => $product->category,
                'total_rating' => $product->getTotalRating(), 
            ];
        });

        return response()->json($products, 200);
    }

    public function getProductsByCategoryID($categoryID)
    {
        $category = Category::find($categoryID);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $products = Product::with('category')->where('categoryID', $category->categoryID)->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found in this category'], 404);
        }

        return response()->json($products, 200);
    }

    public function addRating(Request $request)
    {
        $validated = $request->validate([
            'userID' => 'required|integer',
            'productID' => 'required|integer|exists:products,productID', 
            'orderDetailID' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rating::create($validated);
        return response()->json([
            'message' => 'Rating added successfully',
            'rating' => $rating
        ], 201);
    }

}
