<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan Form Login
    public function index()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Redirect sesuai Role
            $role = Auth::user()->role;
            
            // Sementara kita arahkan semua ke dashboard admin dulu untuk tes layout
            // Nanti kita pisah routingnya
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}