<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Garasi;
use App\Models\SewaGarasi;
use App\Models\User;
use App\Services\LaporanService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function __construct(private LaporanService $laporanService) {}

    /**
     * Menampilkan halaman laporan sewa garasi dengan 4 filter.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['tahun', 'bulan', 'tipe_garasi', 'nik']);
        $laporan = $this->laporanService->getLaporan($filters);

        // Opsi dropdown tahun diambil dari data sewa yang ada + tahun berjalan
        $daftarTahun = SewaGarasi::selectRaw('YEAR(tanggal_mulai) as tahun')
            ->distinct()
            ->pluck('tahun')
            ->push((int) now()->year)
            ->unique()
            ->sortDesc()
            ->values();

        $daftarTipe = array_keys(Garasi::PREFIX_MAP);

        $daftarPenyewa = User::where('role_name', User::ROLE_PENYEWA)
            ->orderBy('nama_lengkap')
            ->get(['nik', 'nama_lengkap']);

        return view('admin.laporan.index', [
            'laporan' => $laporan,
            'filters' => $filters,
            'daftarTahun' => $daftarTahun,
            'daftarTipe' => $daftarTipe,
            'daftarPenyewa' => $daftarPenyewa,
        ]);
    }
}
