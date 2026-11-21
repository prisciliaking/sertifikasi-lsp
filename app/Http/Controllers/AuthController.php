<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Memproses login dan mengecek status validasi khusus penyewa.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        if (!Auth::attempt($request->validated())) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $user = Auth::user();

        // Guard clause: blokir penyewa yang belum diterima admin
        $isAdmin = $user->role_name === User::ROLE_ADMIN;

        if (!$isAdmin && $user->status_validasi !== User::STATUS_DITERIMA) {
            $status = $user->status_validasi;
            Auth::logout();

            $pesan = $status === User::STATUS_MENUNGGU
                ? 'Akun Anda masih menunggu persetujuan Admin.'
                : 'Pendaftaran akun Anda ditolak oleh Admin.';

            return back()->withErrors(['email' => $pesan])->onlyInput('email');
        }

        $request->session()->regenerate();

        return $isAdmin
            ? redirect()->route('admin.users.index')
            : redirect()->route('penyewa.dashboard');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Mendaftarkan penyewa baru dengan status awal menunggu.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        User::create([
            ...$request->validated(),
            'status_validasi' => User::STATUS_MENUNGGU,
            'role_name' => User::ROLE_PENYEWA,
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan tunggu validasi dari Admin sebelum login.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
