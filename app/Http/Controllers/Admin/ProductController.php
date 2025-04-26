<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'brand')->paginate(10);
        $brands = Brand::all();
        $categories = Category::all();

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->save();

        if ($request->hasFile('product_images')) {
            $productImages = $request->file('product_images');
            foreach ($productImages as $image) {
                $uniqueImageName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('product_images', $uniqueImageName, 'public');
                // $image->move('product_images', $uniqueImageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'product_images/' . $uniqueImageName,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }
}
