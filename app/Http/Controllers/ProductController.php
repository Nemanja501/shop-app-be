<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function postProduct(PostProductRequest $request) {
        $validated = $request->validated();
        $imageName = time() . '.' . $validated['image']->getClientOriginalExtension();
        $validated['image']->move(public_path('images'), $imageName);
        Product::create([
            'name' => $validated['name'],
            'imagePath' => '/images' . '/' . $imageName,
            'price' => $validated['price'],
            'user_id' => $validated['user_id'],

        ]);
        return response()->json([
            'message' => 'Product created successfully',
        ]);
    }

    public function getById(string $id) {
        $product = Product::with('user')->find($id);
        if(!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }
        return response()->json([
            'message' => 'Fetched product successfully',
            'product' => $product
        ]);
    }
}
