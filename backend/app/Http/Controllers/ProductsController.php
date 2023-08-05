<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends Controller
{
    public function getProducts(Request $request)
    {
        $products = Product::paginate();

        return response(
            [
                'status' => 'success',
                'data' => $products,
            ],
            Response::HTTP_OK
        );
    }

    public function saveProduct(Request $request)
    {
        $validatedData = $request->validate(
            [
                'id' => 'nullable|exists:products,id',
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'quantity' => 'required|numeric',
                'thumbnail' => 'required|string',
                'isActive' => 'required|boolean',
            ]
        );

        $productId = $validatedData['id'] ?? null;
        
        $product = Product::updateOrCreate(['id' => $productId], $validatedData);
        
        return response()->json(['message' => 'Product saved successfully', 'data' => $product]);
    }
}
