<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        return view('auth.login-admin');
    }

    public function showLoginForm(string $role)
    {
        if (!in_array($role, ['admin', 'petugas', 'siswa'])) {
            return redirect()->route('login.admin');
        }
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        return view('auth.login', compact('role'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role'     => 'required|in:admin,petugas',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'role.required'     => 'Role wajib dipilih.',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            if (Auth::user()->role !== $request->role) {
                Auth::logout();
                return back()->withErrors(['username' => 'Role tidak sesuai dengan akun ini.'])->withInput($request->only('username', 'role'));
            }
            $request->session()->regenerate();
            Auth::user()->update(['last_login_at' => now()]);
            return $this->redirectByRole(Auth::user()->role);
        }

        return back()->withErrors(['username' => 'Username atau password salah.'])->withInput($request->only('username', 'role'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.admin');
    }

    private function redirectByRole(string $role): \Illuminate\Http\RedirectResponse
    {
        return match ($role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'petugas' => redirect()->route('petugas.dashboard'),
            default   => redirect()->route('login.admin'),
        };
    }
}
