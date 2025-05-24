<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'total_amount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $carts = Cart::with('product')
                ->where('user_id', $request->user()->id)
                ->get();

            $totalAmount = $request->total_amount;

            $order = Order::create([
                'user_id' => $request->user()->id,
                'total_amount' => $totalAmount,
                'payment_status' => 'completed'
            ]);

            $orderDetails = [];
            foreach ($carts as $cart) {
                $orderDetails[] = [
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price * $cart->quantity,
                ];
            }

            $order->details()->createMany($orderDetails);

            Cart::where('user_id', $request->user()->id)->delete();
        });

        return redirect()->route('user.products.index')
            ->with('success', 'Pesanan berhasil diselesaikan');
    }
}
