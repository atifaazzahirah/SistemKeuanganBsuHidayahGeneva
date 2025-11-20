<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Login (menggunakan Email)
    public function login(Request $request)
    {
        $request->validate([
            'Email'    => 'required|email',
            'Password' => 'required',
        ]);

        $user = User::where('Email', $request->Email)->first();

        if ($user && Hash::check($request->Password, $user->Password)) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'Email' => 'Email atau password salah.'
        ])->withInput();
    }

    // Proses Register (Username + Email + Password)
    public function register(Request $request)
    {
        $request->validate([
            'Username' => 'required|string|max:50|unique:User,Username',
            'Email'    => 'required|email|unique:User,Email',
            'Password' => 'required|min:6',
        ]);

        User::create([
            'Username' => $request->Username,
            'Email'    => $request->Email,
            'Password' => $request->Password, // akan otomatis di-hash karena ada mutator di model
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}