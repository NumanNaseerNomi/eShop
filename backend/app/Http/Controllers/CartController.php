<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        
        auth()->user()->cart()->attach($productId, ['quantity' => $quantity]);

        return response()->json(['message' => 'Item added to cart successfully']);
    }
}
