<?php

namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Penyewa\StoreSewaRequest;
use App\Models\SewaGarasi;
use App\Services\SewaService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;

class SewaController extends Controller
{
    public function __construct(private SewaService $sewaService) {}

    /**
     * Dashboard penyewa: menampilkan daftar seluruh sewa milik penyewa yang login.
     */
    public function index(Request $request): View
    {
        $sewaList = SewaGarasi::with(['garasi', 'kendaraan'])
            ->where('nik', $request->user()->nik)
            ->latest()
            ->get();

        return view('penyewa.dashboard', compact('sewaList'));
    }

    /**
     * Menampilkan form sewa garasi baru.
     */
    public function create(): View
    {
        return view('penyewa.sewa.create');
    }

    /**
     * Endpoint AJAX untuk mengecek tanggal selesai dan daftar garasi tersedia.
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        try {
            $tanggalMulai = Carbon::parse($request->query('tanggal_mulai', today()->toDateString()))->startOfDay();
            $tipeSewa = $request->query('tipe_sewa', SewaGarasi::TIPE_HARIAN);
            $jumlahHari = $request->query('jumlah_hari') ? (int) $request->query('jumlah_hari') : null;
            $tipeGarasi = $request->query('tipe_garasi');

            $tanggalSelesai = $this->sewaService->hitungTanggalSelesai($tanggalMulai, $tipeSewa, $jumlahHari);
            $garasi = $tipeGarasi
                ? $this->sewaService->getAvailableGarasi($tipeGarasi, $tanggalMulai, $tanggalSelesai)
                : collect();

            return response()->json([
                'tanggal_selesai_ui' => $tanggalSelesai->format('d-m-y'),
                'maks_hari' => $tanggalMulai->daysInMonth - 1,
                'garasi' => $garasi,
            ]);
        } catch (InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Menyimpan transaksi sewa baru.
     */
    public function store(StoreSewaRequest $request): RedirectResponse
    {
        try {
            $sewa = $this->sewaService->createSewa(
                $request->user(),
                $request->validated(),
                $request->file('bukti_bayar')
            );

            return redirect()->route('penyewa.dashboard')
                ->with('success', "Sewa {$sewa->sewa_id} pada garasi {$sewa->garasi_id} berhasil disimpan!");
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['garasi_id' => $e->getMessage()])->withInput();
        }
    }
}
