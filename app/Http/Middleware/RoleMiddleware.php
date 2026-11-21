<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Memastikan user sudah login, memiliki role sesuai, dan sudah divalidasi (khusus penyewa).
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user || $user->role_name !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        if ($user->role_name === User::ROLE_PENYEWA && !$user->isApproved()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda belum disetujui atau ditolak oleh Admin.']);
        }

        return $next($request);
    }
}
