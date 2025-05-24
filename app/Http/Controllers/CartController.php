<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller {
    public function index(Request $request) {
    }

    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'product_id' => $request->input('product_id'),
            ],
            [
                'quantity' => DB::raw('quantity + ' . $request->input('quantity')),
            ]
        );

        $cartCount = Cart::where('user_id', $request->user()->id)->count();

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => $cartCount
        ]);
    }

    public function fetchUserCart(Request $request) {
        if ($request->mode == "count") {
            $cartCount = Cart::where('user_id', $request->user()->id)->count();
            return response()->json(['cart_count' => $cartCount]);
        }

        $cartItems = Cart::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        return response()->json(['cart' => $cartItems]);
    }
}
