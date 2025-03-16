<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Pencarian
Route::get('/search', function () {
    return 'Hasil Pencarian';
});

// Produk
Route::get('/products', function () {
    return 'Daftar Produk';
});

Route::get('/product/detail', function () {
    return 'Detail Produk';
});

Route::get('/product/reviews', function () {
    return 'Ulasan Produk';
});

// Kategori dan Filter
Route::get('/categories', function () {
    return 'Daftar Kategori Produk';
});

Route::get('/filter', function () {
    return 'Hasil Filter Produk';
});

// Keranjang Belanja dan Checkout
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

// Pengguna (Autentikasi dan Profil)
Route::get('/login', function () {
    return 'Halaman Login';
});

Route::get('/login/process', function () {
    return 'Proses Login';
});

Route::get('/register', function () {
    return 'Halaman Registrasi';
});

Route::get('/register/process', function () {
    return 'Proses Registrasi';
});

Route::get('/profile', function () {
    return 'Profil Pengguna';
});

Route::get('/profile/orders', function () {
    return 'Daftar Pesanan';
});

Route::get('/profile/order/detail', function () {
    return 'Detail Pesanan';
});

// Penjual
Route::get('/sellers', function () {
    return 'Daftar Penjual';
});

Route::get('/seller/products', function () {
    return 'Produk Penjual';
});

// Transaksi dan Pembayaran
Route::get('/payment', function () {
    return 'Halaman Pembayaran';
});

Route::get('/payment/process', function () {
    return 'Proses Pembayaran';
});

// Ulasan dan Rating
Route::get('/reviews/submit', function () {
    return 'Ulasan untuk Produk';
});

// Lainnya
Route::get('/promo', function () {
    return 'Halaman Promo';
});

Route::get('/contact', function () {
    return 'Halaman Kontak';
});

Route::get('/about', function () {
    return 'Halaman Tentang Kami';
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
