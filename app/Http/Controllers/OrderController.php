<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {
    public function index(Request $request) {
        $orders = Order::with(['details.product', 'user']);

        if ($request->has('month')) {
            if ($request->month == 'all') {
                $orders->whereYear('created_at', now()->year);
            } else {
                $orders->whereMonth('created_at', $request->month);
            }
        }

        if ($request->has('year') && $request->year != '') {
            $orders->whereYear('created_at', $request->year);
        }

        if (!$request->has('month') && !$request->has('year')) {
            $orders->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        }

        $orders = $orders->orderBy('created_at', 'desc')->get();

        return view('dashboard.order.index', [
            'orders' => $orders,
        ])->with('title', 'Daftar Pesanan');
    }

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
