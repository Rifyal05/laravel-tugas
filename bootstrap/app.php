<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check_customer_login' => App\Http\Middleware\CheckCustomerLogin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

// Fokus pada bagian ->withMiddleware
// Kemudian update lagi file route/web.php menjadi seperti berikut:

Route::group(['prefix' => 'customer'], function () {
    Route::controller(CustomerAuthController::class)->group(function () {
        Route::group(['middleware' => 'check_customer_login'], function () {
            // tampilkan halaman login
            Route::get('login', 'login')->name('customer.login');
            // aksi login
            Route::post('login', 'store_login')->name('customer.store_login');
            // tampilkan halaman register
            Route::get('register', 'register')->name('customer.register');
            // aksi register
            Route::post('register', 'store_register')->name('customer.store_register');
        });

        // aksi logout
        Route::post('logout', 'logout')->name('customer.logout');
    });
});


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check_customer_login' => App\Http\Middleware\CheckCustomerLogin::class,
            'is_customer_login'    => App\Http\Middleware\IsCustomerLogin::class, // <-- Ditambahkan
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
