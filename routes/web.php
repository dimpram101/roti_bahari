<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if ($request->user()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});

Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'dashboard'], function () {
    Route::get('/', function () {
        return view('dashboard');
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
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
