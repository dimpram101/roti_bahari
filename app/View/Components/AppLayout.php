<?php

namespace App\View\Components;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $cart = Cart::where('user_id', Auth::user()->id)
            ->count();

        return view('layouts.app', [
            'cart' => $cart
        ]);
    }
}
