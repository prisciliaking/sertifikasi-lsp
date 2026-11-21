<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserValidationController extends Controller
{
    /**
     * Menampilkan daftar seluruh penyewa beserta status validasinya.
     */
    public function index(): View
    {
        $penyewaList = User::where('role_name', User::ROLE_PENYEWA)
            ->orderByRaw("FIELD(status_validasi, 'menunggu', 'diterima', 'ditolak')")
            ->latest()
            ->get();

        return view('admin.users.index', compact('penyewaList'));
    }

    /**
     * Mengubah status validasi penyewa (diterima / ditolak).
     */
    public function updateStatus(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'status_validasi' => ['required', Rule::in([User::STATUS_DITERIMA, User::STATUS_DITOLAK])],
        ]);

        $user->update($validated);

        return back()->with('success', "Status penyewa {$user->nama_lengkap} berhasil diubah menjadi {$validated['status_validasi']}.");
    }
}
