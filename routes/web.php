<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $user = $request->user();
    if ($user) {
        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard');
        } elseif ($user->hasRole('user')) {
            return redirect()->route('user.home');
        }
    } else {
        return redirect()->route('login');
    }
});

Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'dashboard'], function () {
    Route::get('/', function () {
        $users = User::with('roles')
            ->get()
            ->groupBy(function ($user) {
                return $user->roles->pluck('name')->first();
            })
            ->map(function ($group) {
                return $group->count();
            });

        $products = Product::all()->count();

        $todayIncome = Order::whereDate('created_at', now())->sum('total_amount');
        $monthlyIncome = Order::whereMonth('created_at', now()->month)->sum('total_amount');
        $orderCount = Order::count();
        
        return view('dashboard.home', [
            'users' => $users,
            'products' => $products,
            'income' => [
                'today' => $todayIncome,
                'monthly' => $monthlyIncome,
            ],
            'orderCount' => $orderCount,
        ])->with('title', 'Dashboard');
    })->name('dashboard');

    Route::resource('products', ProductController::class)->names([
        'index' => 'products.index',
        'store' => 'products.store',
        'update' => 'products.update',
        'destroy' => 'products.destroy',
    ]);

    Route::resource('users', UserController::class)->names([
        'index' => 'users.index',
        'store' => 'users.store',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);

    Route::resource('categories', CategoryController::class)->names([
        'store' => 'categories.store',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy',
    ]);

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::put('messages/{message}/toggle', [MessageController::class, 'toggleStatus'])->name('messages.toggleStatus');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});

Route::group(['middleware' => ['auth', 'role:user'], 'prefix' => 'user'], function () {
    Route::get('/home', function () {
        $categories = Category::all();
        $best_selling_products = Product::all();

        return view('home', [
            'categories' => $categories,
            'best_selling_products' => $best_selling_products,
        ])->with('title', 'User Home');;
    })->name('user.home');

    Route::prefix('carts')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('user.carts.index');
        Route::post('/', [CartController::class, 'store'])->name('user.carts.store');
        Route::post('/increase/{cart}', [CartController::class, 'increase'])->name('cart.increase');
        Route::post('/decrease/{cart}', [CartController::class, 'decrease'])->name('cart.decrease');
        Route::delete('/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    });

    Route::post('/orders', [OrderController::class, 'store'])->name('user.orders.store');

    Route::get('/products', [ProductController::class, 'userIndex'])->name('user.products.index');

    Route::get('/message', [MessageController::class, 'create'])->name('user.message.create');
    Route::post('/message', [MessageController::class, 'store'])->name('user.message.store');
    
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.updatePicture');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
