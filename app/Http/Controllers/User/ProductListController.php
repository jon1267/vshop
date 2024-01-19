<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductListController extends Controller
{
    public function index()
    {
        // lesson 14, TIME 13:31
        //$products = Product::with('category', 'brand', 'product_images')->get();
        //$filterProducts = $products->filtered()->paginate(9)->withQueryString();
        $filterProducts = Product::with('category', 'brand', 'product_images')
            ->filtered()
            ->paginate(9)
            ->withQueryString();

        return Inertia::render('User/ProductList', [
                'products' => ProductResource::collection($filterProducts)
            ]
        );
    }
}
