<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\CustomerAuthController;

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {
    Route::view('/', 'dashboard')->name('dashboard');
    Route::resource('categories', ProductCategoryController::class);
    Route::resource('products', ProductController::class);
});

Route::get('/home', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/', [HomepageController::class, 'index'])->name('homepage.index');
Route::get('products', [HomepageController::class, 'products'])->name('homepage.products');
Route::get('product/{slug}', [HomepageController::class, 'product'])->name('homepage.product.detail');
Route::get('categories', [HomepageController::class, 'categories'])->name('homepage.categories');
Route::get('category/{slug}', [HomepageController::class, 'category'])->name('homepage.category.detail');
Route::get('cart', [HomepageController::class, 'cart'])->name('homepage.cart');
Route::get('checkout', [HomepageController::class, 'checkout'])->name('homepage.checkout');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::prefix('customer')->controller(CustomerAuthController::class)->group(function () {
    Route::middleware('check_customer_login')->group(function () {
        Route::get('login', 'login')->name('customer.login');
        Route::get('register', 'register')->name('customer.register');
    });

    Route::post('login', 'store_login')->name('customer.store_login');
    Route::post('register', 'store_register')->name('customer.store_register');
    Route::post('logout', 'logout')->name('customer.logout');
});


require __DIR__.'/auth.php';