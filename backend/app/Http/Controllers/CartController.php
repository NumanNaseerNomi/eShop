<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        
        $cartItem = new Cart(['product_id' => $request->product_id, 'quantity' => $quantity]);
        
        auth()->user()->cart()->save($cartItem);

        return response()->json(['message' => 'Item added to cart successfully']);
    }
}
