<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username'  => 'required',
            'kata_sandi'=> 'required'
        ]);

        $user = Pengguna::where('username', $request->username)->first();

        if (!$user) {
            return back()->with('error', 'User tidak ditemukan');
        }

        if ($user->kata_sandi !== $request->kata_sandi) {
            return back()->with('error', 'Password salah');
        }

        Session::put('user', $user);

        return redirect('/dashboard');
    }
}
