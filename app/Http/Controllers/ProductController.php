<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {
    public function index(Request $request) {
        $products = Product::with('category')->get();
        $categories = Category::all();
        // Logic to list products
        return view('dashboard.product.index', [
            'products' => $products,
            'categories' => $categories,
            'queries' => $request->query(),
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageName = str_replace(' ', '_', $request->name) . '_' . date('Ymd_His') . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('images/products', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }

        $product = Product::create($validatedData);

        // Logic to store product
        return redirect()->route('products.index')->with('success', 'Product berhasil ditambahkan.');
    }

    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageName = str_replace(' ', '_', $request->name) . '_' . date('Ymd_His') . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('images/products', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }

        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Product berhasil diperbarui.');
    }

    public function destroy(Request $request, $id) {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product berhasil dihapus.');
    }
}
