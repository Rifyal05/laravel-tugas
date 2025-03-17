<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/search', function () {
    return 'Hasil Pencarian';
});
Route::get('/wishlits', function () {
    return 'wishlist anda';
});
Route::get('/products', function () {
    return 'Daftar Produk';
});

Route::get('mitraname/product', function () {
    return 'Detail Produk';
});

Route::get('mitraname/product/reviews', function () {
    return 'Ulasan Produk';
});

Route::get('/p/products', function () {
    return 'Daftar Kategori Produk';
});

Route::get('/p/product/filter', function () {
    return 'Hasil Filter Produk';
});

Route::get('/cart', function () {
    return 'Keranjang Belanja';
});

Route::get('/cart/add', function () {
    return 'Produk ditambahkan ke keranjang';
});

Route::get('/checkout', function () {
    return 'Halaman Checkout';
});

Route::get('/checkout/process', function () {
    return 'Proses Checkout';
});

Route::get('/login', function () {
    return 'Halaman Login';
});
Route::get('/order-list', function () {
    return 'Halaman List order';
});

Route::get('/register', function () {
    return 'Halaman Registrasi';
});

Route::get('/user', function () {
    return 'Profil Pengguna';
});

Route::get('/user/settings', function () {
    return 'Daftar Pesanan';
});

Route::get('/mitra', function () {
    return 'Daftar Penjual';
});

Route::get('/mitra/products', function () {
    return 'Produk Penjual';
});

Route::get('/payment', function () {
    return 'Halaman Pembayaran';
});

Route::get('/mitra/products/review/submit', function () {
    return 'Ulasan untuk Produk';
});

Route::get('/promo', function () {
    return 'Halaman Promo';
});
Route::get('/about', function () {
    return 'Halaman Tentang Kami';
});
Route::get('/reset-password', function () {
    return 'Halaman Reset Password';
});
Route::get('/help', function () {
    return 'Pusat Bantuan';
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
