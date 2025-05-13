<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'description' => 'nullable|string',
        ]);

        Category::create($validatedData);

        // Logic to store category
        return redirect()->route('products.index')->with('success', 'Category berhasil ditambahkan.');
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);

        $category->update($validatedData);

        // Logic to update category
        return redirect()->route('products.index')->with('success', 'Category berhasil diperbarui.');
    }

    public function destroy(Request $request, $id) {
        $category = Category::findOrFail($id);

        if ($category->products()->count() > 0) {
            return redirect()->route('products.index')->with('error', 'Category tidak dapat dihapus karena memiliki produk.');
        }

        $category->delete();

        return redirect()->route('products.index')->with('success', 'Category berhasil dihapus.');
    }
}
