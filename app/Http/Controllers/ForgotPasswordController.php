<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // STEP 1: Tampilkan form lupa password
    public function index()
    {
        return view('auth.lupa_password');
    }

    // STEP 1: Kirim kode reset ke email
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan!');
        }

        // Generate OTP 6 digit
        $token = rand(100000, 999999);

        // Kirim email
        Mail::raw(
            "Kode reset password Anda adalah: $token",
            function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Reset Password - Bank Sampah Hidayah Geneva');
            }
        );

        // Simpan OTP dan email di session
        session([
            'reset_token' => $token,
            'email_reset' => $request->email,
        ]);

        // Tandai agar view menampilkan form STEP 2
        return back()->with('success', 'Kode reset password telah dikirim ke email Anda.')
                     ->with('show_step2', true);
    }

    // STEP 2: Update password
    public function update(Request $request)
    {
        $request->validate([
            'token' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
        ]);

        $sessionToken = session('reset_token');
        $email = session('email_reset');

        if (!$sessionToken || !$email) {
            return redirect()->route('password.request')
                             ->with('error', 'Kode reset tidak ditemukan. Silakan coba lagi.');
        }

        // Cek token
        if ($request->token != $sessionToken) {
            return back()->with('error', 'Kode reset salah!')->with('show_step2', true);
        }

        // Update password user
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.request')
                             ->with('error', 'Email tidak ditemukan.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus session setelah berhasil reset
        session()->forget(['reset_token', 'email_reset', 'show_step2']);

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login.');
    }
}
