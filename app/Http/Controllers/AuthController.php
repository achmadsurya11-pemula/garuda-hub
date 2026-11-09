<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectHome();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => strtolower(trim($request->email)),
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectHome()->with('ok', 'Selamat datang kembali.');
        }

        return back()->withInput($request->only('email'))
            ->with('err', 'Email atau password salah.');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectHome();
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|max:72',
            'role' => 'required|in:klien,developer',
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.in' => 'Peran tidak valid.',
        ]);

        User::create([
            'nama' => trim($request->nama),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login')->with('ok', 'Pendaftaran berhasil. Silakan masuk.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('ok', 'Anda telah keluar.');
    }

    private function redirectHome()
    {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.index')
            : redirect()->route('dashboard');
    }
}
