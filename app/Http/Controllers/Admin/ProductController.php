<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{

    public function index()
    {
        $vendorId = Auth::id();
        $products = Product::where('user_id', $vendorId)->get();

        return view('admin.products.products', [
            'products' => $products
        ]);
    }


    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::all('id', 'title')
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|image|max:1024',
            'about' => 'required|max:1000',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|numeric|min:0',
            'discount' => 'multiple_of:5|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);
        $vendorId = Auth::id();
        $path = $request->file('image')->store('products', 'public');
        $product = new Product();
        $category = Category::find($validated['category_id']);

        $product->title = $validated['title'];
        $product->image = $path;
        $product->about = $validated['about'];
        $product->price = $validated['price'];
        $product->stock_quantity = $validated['stock_quantity'];
        $product->user_id = $vendorId;

        $request->whenHas('discount', function ($input) use ($product) {
            $product->discount = $input;
        });

        $category->products()->save($product);

        return redirect()->route('admin.products.index')->with('status', 'product added successfully');
    }


    // public function show(Product $product)



    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all('id', 'title')
        ]);
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'image' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'about' => 'required|max:1000',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|numeric|min:0',
            'discount' => 'multiple_of:5|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $product->title = $validated['title'];

        if ($request->has(['image', 'discount'])) {
            $path = $request->file('image')->store('products', 'public');
            if ($product->image) {
                Storage::delete($product->image);
            }
            $product->image = $path;

            $product->discount = $validated['discount'];
        }

        $product->about = $validated['about'];
        $product->price = $validated['price'];
        $product->stock_quantity = $validated['stock_quantity'];

        $category = Category::find($validated['category_id']);

        $category->products()->save($product);


        return redirect()->route('admin.products.index')->with('status', 'product updated successfully');
    }


    public function destroy(Product $product)
    {
        Storage::delete($product->image);
        $title = $product->title;
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'product "' . $title . '" deleted successfully');
    }
}
