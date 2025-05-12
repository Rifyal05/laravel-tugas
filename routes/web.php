<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\Dashboard\ProductController;

// Grup untuk route dashboard
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {
    Route::view('/', 'dashboard')->name('dashboard');
    Route::resource('categories', ProductCategoryController::class);

    // Resource route untuk Products
    Route::resource('products', ProductController::class);
});

// Routes/web.php
Route::get('/home', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('home');

// Route untuk Homepage (Frontend)
Route::get('/', [HomepageController::class, 'index'])->name('homepage.index');
Route::get('products', [HomepageController::class, 'products'])->name('homepage.products');
Route::get('product/{slug}', [HomepageController::class, 'product'])->name('homepage.product.detail');
Route::get('categories',[HomepageController::class, 'categories'])->name('homepage.categories');
Route::get('category/{slug}', [HomepageController::class, 'category'])->name('homepage.category.detail');
Route::get('cart', [HomepageController::class, 'cart'])->name('homepage.cart');
Route::get('checkout', [HomepageController::class, 'checkout'])->name('homepage.checkout');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';