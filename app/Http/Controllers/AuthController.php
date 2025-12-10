<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib diimport untuk fitur Login

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // --- PERBAIKAN LOGIKA REDIRECT DI SINI ---
            
            // Jika dia Admin, arahkan ke Dashboard Admin
            if (Auth::user()->peran === 'admin') {
                return redirect()->intended('/admin/dashboard'); 
                // Catatan: sesuaikan path '/admin/dashboard' atau '/dashboard' 
                // sesuai route name 'admin.dashboard' di web.php Anda
            }

            // Jika dia User Biasa, arahkan ke Halaman Utama (Home) untuk belanja
            return redirect()->intended('/');
        }

        return back()->with('error', 'Email atau password salah!');
    }
    
    // Tambahkan fitur Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}