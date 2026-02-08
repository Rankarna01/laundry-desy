<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    // --- FUNGSI BARU: REGISTER ---
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email', // Email gak boleh kembar
            'no_hp'     => 'required|numeric',
            'password'  => 'required|min:6',
        ]);

        // Buat User Baru
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'no_hp'    => $request->no_hp,
            'password' => Hash::make($request->password),
            'role'     => 'pengguna', // Paksa jadi Pengguna
        ]);

        // Opsional: Langsung login setelah register
        // atau redirect ke login dengan pesan sukses.
        // Kita pilih redirect biar user tau akunnya berhasil dibuat.
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan Login.');
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