<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProductCategoryController;

Route::get('/home', function () {
    return view('welcome');
})->name('home');

// Route::get('/search', function () {
//     return 'Hasil Pencarian';
// });
// Route::get('/wishlits', function () {
//     return 'wishlist anda';
// });
// Route::get('/products', function () {
//     return 'Daftar Produk';
// });

// Route::get('mitraname/product/(slug)', function ($slug) {
//     return 'Detail Produk'.$slug;
// });

// Route::get('mitraname/product/reviews', function () {
//     return 'Ulasan Produk';
// });

// Route::get('/p/products', function () {
//     return 'Daftar Kategori Produk';
// });

// Route::get('/p/product/filter', function () {
//     return 'Hasil Filter Produk';
// });

// Route::get('/cart', function () {
//     return 'Keranjang Belanja';
// });

// Route::get('/cart/add', function () {
//     return 'Produk ditambahkan ke keranjang';
// });

// Route::get('/checkout', function () {
//     return 'Halaman Checkout';
// });

// Route::get('/checkout/process', function () {
//     return 'Proses Checkout';
// });

// Route::get('/login', function () {
//     return 'Halaman Login';
// });
// Route::get('/order-list', function () {
//     return 'Halaman List order';
// });

// Route::get('/register', function () {
//     return 'Halaman Registrasi';
// });

// Route::get('/user', function () {
//     return 'Profil Pengguna';
// });

// Route::get('/user/settings', function () {
//     return 'Daftar Pesanan';
// });

// Route::get('/mitra', function () {
//     return 'Daftar Penjual';
// });

// Route::get('/mitra/products', function () {
//     return 'Produk Penjual';
// });

// Route::get('/payment', function () {
//     return 'Halaman Pembayaran';
// });

// Route::get('/mitra/products/review/submit', function () {
//     return 'Ulasan untuk Produk';
// });

// Route::get('/promo', function () {
//     return 'Halaman Promo';
// });
// Route::get('/about', function () {
//     return 'Halaman Tentang Kami';
// });
// Route::get('/reset-password', function () {
//     return 'Halaman Reset Password';
// });
// Route::get('/help', function () {
//     return 'Pusat Bantuan';
// });

// Route::get('/', function(){
//     return view('web.homepage');
//    });
   
// Route::get('products', function(){
//     return view('web.product');
//    });
// Route::get('product/{slug}', function($slug){
//     return "halaman single product - ".$slug;
//    });
// Route::get('categories', function(){
//     return view('web.categories');
//    });
// Route::get('category/{slug}', function($slug){
//     return "halaman single category - ".$slug;
//    });
// Route::get('cart', function(){
//     return "halaman cart";
//    });
// Route::get('checkout', function(){
//     return "halaman checkout";
//    });   

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::group(['prefix' => 'dashboard'], function () {
        Route::resource('categories', ProductCategoryController::class);
    });

Route::get('/', [HomepageController::class, 'index']);
Route::get('products', [HomepageController::class, 'products']);
Route::get('product/{slug}', [HomepageController::class, 'product']);
Route::get('categories',[HomepageController::class, 'categories']);
Route::get('category/{slug}', [HomepageController::class, 'category']);
Route::get('cart', [HomepageController::class, 'cart']);
Route::get('checkout', [HomepageController::class, 'checkout']);


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
