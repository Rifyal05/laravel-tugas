<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerAuthController extends Controller
{
    public function login()
    {
        return view('web.customer.login', [
            'title' => 'Customer Login'
        ]);
    }

    public function store_login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $guard = 'customer'; // Pastikan guard ini sesuai

        if (Auth::guard($guard)->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('homepage.index')); // Tetap ke homepage setelah login
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function register()
    {
        return view('web.customer.register', [
            'title' => 'Customer Register'
        ]);
    }

    public function store_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.register')
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('customer.login')->with('success', 'Registrasi berhasil! Silakan login.');

        } catch (\Exception $e) {
            return redirect()->route('customer.register')
                        ->with('error', 'Registrasi gagal. Silakan coba lagi.')
                        ->withInput();
        }
    }

    public function logout(Request $request)
    {
        $guard = 'customer'; // Pastikan guard ini sesuai
        Auth::guard($guard)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // UBAH BARIS INI:
        // Awalnya: return redirect()->route('homepage.index')->with('success', 'Anda telah berhasil logout.');
        // Menjadi:
        return redirect()->route('customer.login')->with('success', 'Anda telah berhasil logout. Silakan login kembali jika perlu.');
    }
}