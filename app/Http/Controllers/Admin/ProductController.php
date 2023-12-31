<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'brand', 'product_images')->get();
        $brands = Brand::get();
        $categories = Category::get();

        return Inertia::render('Admin/Product/Index', [
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        //dd($request->file('product_images'));
        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->save();

        //check if $request has images
        if ($request->hasFile('product_images'))
        {
            $productImages = $request->file('product_images');
            foreach ($productImages as $image)
            {
                // generate unique name for image as timestamp && random string
                $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->move('product_images', $uniqueName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'product_images/' . $uniqueName,
                ]);
            }
        }
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function update(Request $request, int|string $id)
    {
        $product = Product::findOrFail($id);
        $product->title = $request->title;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        //check if $request has images
        if ($request->hasFile('product_images'))
        {
            $productImages = $request->file('product_images');
            foreach ($productImages as $image)
            {
                // generate unique name for image as timestamp && random string
                $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->move('product_images', $uniqueName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'product_images/' . $uniqueName,
                ]);
            }
        }

        $product->update();

        return redirect()->back()->with('success', 'Product successfully updated');
    }

    public function deleteImage(int|string $id)
    {
        $image = ProductImage::where('id', $id)->first();

        if ($image) {
            $image->delete();
            redirect()->route('admin.products.index')->with('success', 'Image deleted successfully');
        }

        return redirect()->route('admin.products.index')->with('error', 'Image not found');
    }

    public function deleteProduct(int|string $id)
    {
        $product = Product::findOrFail($id)->delete();

        redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
