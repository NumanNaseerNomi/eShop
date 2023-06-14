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
        // dd($products);
        // $request->user()->currentAccessToken()->delete();

        return response(
            [
                'status' => 'success',
                'data' => $products,
            ],
            Response::HTTP_OK
        );
    }
}
