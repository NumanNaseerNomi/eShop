<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $validationRules =
        [
            'id' => 'nullable|exists:products,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'thumbnail' => 'required|image',
            'isActive' => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if($validator->fails())
        {
            return response(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        else
        {
            $validatedData = $validator->validated();
            
            if($request->hasFile('thumbnail'))
            {
                $validatedData['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
            }

            $productId = $validatedData['id'] ?? null;
            $product = Product::updateOrCreate(['id' => $productId], $validatedData);

            return response()->json(['message' => 'Product saved successfully', 'data' => $product]);
        }
    }

    public function deleteProduct(Request $request)
    {
        $validator = Validator::make($request->all(), ['id' => 'required|exists:products,id']);

        if($validator->fails())
        {
            return response(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        else
        {
            $product = Product::destroy($request->input('id'));

            return $product 
                ? response()->json(['message' => 'Product deleted successfully'])
                : response()->json(['message' => 'Product not found'], 404);
        }
    }
}
