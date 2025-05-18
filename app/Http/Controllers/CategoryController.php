<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller {
    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageName = str_replace(' ', '_', $request->name) . '_' . date('Ymd_His') . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('images/categories', $imageName, 'public');
            $validatedData['img_url'] = $imagePath;
        }

        Category::create($validatedData);

        // Logic to store category
        return redirect()->route('products.index')->with('success', 'Category berhasil ditambahkan.');
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::findOrFail($id);
        if ($request->hasFile('image')) {
            if ($category->img_url) {
                Storage::disk('public')->delete($category->img_url);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageName = str_replace(' ', '_', $request->name) . '_' . date('Ymd_His') . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('images/categories', $imageName, 'public');
            $validatedData['img_url'] = $imagePath;
        }
        $category->update($validatedData);

        // Logic to update category
        return redirect()->route('products.index')->with('success', 'Category berhasil diperbarui.');
    }

    public function destroy(Request $request, $id) {
        $category = Category::findOrFail($id);

        if ($category->products()->count() > 0) {
            return redirect()->route('products.index')->with('error', 'Category tidak dapat dihapus karena memiliki produk.');
        }

        if ($category->img_url) {
            Storage::disk('public')->delete($category->img_url);
        }

        $category->delete();

        return redirect()->route('products.index')->with('success', 'Category berhasil dihapus.');
    }
}
