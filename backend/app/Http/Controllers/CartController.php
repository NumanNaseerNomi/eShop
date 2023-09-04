<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function getCartItems(Request $request)
    {
        $items = auth()->user()->cart()->paginate();

        return response(
            [
                'status' => 'success',
                'data' => $items,
            ],
            Response::HTTP_OK
        );
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product_id' => 'required|numeric|exists:products,id',
                'quantity' => 'integer|min:1',
            ]
        );
        
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        
        $cartItem = new Cart(['product_id' => $request->product_id, 'quantity' => $quantity]);
        
        auth()->user()->cart()->save($cartItem);

        return response()->json(['message' => 'Item added to cart successfully']);
    }
}
