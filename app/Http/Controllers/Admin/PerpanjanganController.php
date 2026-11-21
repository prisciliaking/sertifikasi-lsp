<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExtendSewaRequest;
use App\Models\SewaGarasi;
use App\Services\SewaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use InvalidArgumentException;

class PerpanjanganController extends Controller
{
    public function __construct(private SewaService $sewaService) {}

    /**
     * Menampilkan daftar garasi yang sedang disewa hari ini dan ke depannya.
     */
    public function index(): View
    {
        $sewaAktif = SewaGarasi::with(['penyewa', 'garasi', 'kendaraan'])
            ->where('tanggal_selesai', '>=', today())
            ->orderBy('tanggal_selesai')
            ->get();

        return view('admin.perpanjangan.index', compact('sewaAktif'));
    }

    /**
     * Menampilkan form perpanjangan untuk satu transaksi sewa.
     */
    public function edit(SewaGarasi $sewa): View
    {
        $sewa->load(['penyewa', 'garasi', 'kendaraan', 'perpanjangan']);

        return view('admin.perpanjangan.edit', compact('sewa'));
    }

    /**
     * Memproses penyimpanan perpanjangan sewa oleh Admin.
     */
    public function update(ExtendSewaRequest $request, SewaGarasi $sewa): RedirectResponse
    {
        try {
            $sewa->load('garasi');

            $this->sewaService->extendSewa(
                $sewa,
                $request->user(),
                $request->validated('tipe_perpanjangan'),
                (int) $request->validated('durasi'),
                $request->file('bukti_bayar')
            );

            return redirect()->route('admin.perpanjangan.index')
                ->with('success', "Sewa {$sewa->sewa_id} (Garasi {$sewa->garasi_id}) berhasil diperpanjang!");
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['durasi' => $e->getMessage()])->withInput();
        }
    }
}
