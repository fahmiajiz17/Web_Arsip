<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Login form.
     */
    public function login(): View
    {
        // tampilkan form login
        $profil = \App\Models\Profil::first();
        return view('auth.login', compact('profil'));
    }

    /**
     * Login authentication.
     */
    public function authenticate(Request $request): RedirectResponse
{
    // validasi form termasuk reCAPTCHA
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
        'g-recaptcha-response' => 'required|recaptcha',
    ], [
        'username.required' => 'Username tidak boleh kosong.',
        'password.required' => 'Password tidak boleh kosong.',
        'g-recaptcha-response.required' => 'Verifikasi CAPTCHA wajib diisi.',
        'g-recaptcha-response.captcha' => 'Verifikasi CAPTCHA gagal. Coba lagi.',
    ]);

    // jika login berhasil
    if (Auth::attempt($request->only('username', 'password'))) {
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard.index'));
    }

    // jika login gagal
    return back()->with('error', 'Username atau Password salah. Cek kembali Username dan Password Anda.');
}

    /**
     * Logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // redirect ke halaman login dan tampilkan pesan berhasil logout
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}