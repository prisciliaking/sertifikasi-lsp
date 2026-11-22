<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGarasiBatchRequest;
use App\Models\Garasi;
use App\Services\GarasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;

class GarasiController extends Controller
{
    public function __construct(private GarasiService $garasiService) {}

    /**
     * Menampilkan daftar garasi dengan filter opsional berdasarkan tipe.
     */
    public function index(Request $request): View
    {
        $filterTipe = $request->query('tipe');

        $garasiList = Garasi::with([
            'sewaGarasi' => fn($q) => $q
                ->with('penyewa:nik,nama_lengkap')
                ->where('tanggal_selesai', '>=', today())
                ->orderBy('tanggal_mulai'),
        ])
            ->when($filterTipe, fn($q) => $q->where('tipe_garasi', $filterTipe))
            ->orderBy('garasi_id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.garasi.index', compact('garasiList', 'filterTipe'));
    }

    /**
     * Menyimpan batch garasi baru.
     */
    public function store(StoreGarasiBatchRequest $request): RedirectResponse
    {
        try {
            $dibuat = $this->garasiService->createBatch($request->validated());

            return redirect()->route('admin.garasi.index')
                ->with('success', "Berhasil membuat {$dibuat} unit garasi {$request->tipe_garasi}.");
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['jumlah' => $e->getMessage()])->withInput();
        }
    }
}
