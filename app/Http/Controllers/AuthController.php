<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    // --- LOGIN VIA USERNAME ---
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required', // Ganti email jadi username
            'password' => 'required',
        ]);

        // Auth::attempt menggunakan array ['kolom_db' => input, 'password' => input]
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            $role = Auth::user()->role;
            
            return match($role) {
                'admin'    => redirect()->route('dashboard'),
                'karyawan' => redirect()->route('karyawan.dashboard'),
                'pengguna' => redirect()->route('member.dashboard'),
                default    => redirect('/login'),
            };
        }

        return back()->with('error', 'Username atau password salah!');
    }

    // --- REGISTER LENGKAP ---
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|unique:users,username|alpha_dash', // Unik & tanpa spasi
            'no_hp'     => 'required|numeric',
            'email'     => 'required|email|unique:users,email',
            'alamat'    => 'required|string',
            'password'  => 'required|min:6|confirmed', // 'confirmed' butuh input name="password_confirmation"
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'no_hp'    => $request->no_hp,
            'email'    => $request->email,
            'alamat'   => $request->alamat,
            'password' => Hash::make($request->password),
            'role'     => 'pengguna',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan Username Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}