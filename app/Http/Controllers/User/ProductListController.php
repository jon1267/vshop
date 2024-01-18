<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductListController extends Controller
{
    public function index()
    {
        // lesson 14, TIME 13:31
        $products = Product::with('category', 'brand', 'product_images')->get();
        return Inertia::render('User/ProductList',
            ['products' => $products]
        );
    }
}
