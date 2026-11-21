<?php

namespace App\Services;

use App\Models\SewaGarasi;
use Illuminate\Support\Collection;

class LaporanService
{
    /**
     * Mengambil data laporan sewa garasi beserta ringkasan rekap sesuai filter aktif.
     *
     * @param array{tahun?: ?int, bulan?: ?int, tipe_garasi?: ?string, nik?: ?int} $filters
     * @return array{
     *     transaksi: Collection,
     *     rekap: Collection,
     *     judul_rekap: string,
     *     total_transaksi: int,
     *     total_pendapatan: float
     * }
     */
    public function getLaporan(array $filters): array
    {
        $tahun = !empty($filters['tahun']) ? (int) $filters['tahun'] : null;
        $bulan = !empty($filters['bulan']) ? (int) $filters['bulan'] : null;
        $tipeGarasi = $filters['tipe_garasi'] ?? null;
        $nik = !empty($filters['nik']) ? (int) $filters['nik'] : null;

        $transaksi = SewaGarasi::with(['penyewa', 'garasi', 'kendaraan'])
            ->when($tahun, fn($q) => $q->whereYear('tanggal_mulai', $tahun))
            ->when($bulan, fn($q) => $q->whereMonth('tanggal_mulai', $bulan))
            ->when($tipeGarasi, fn($q) => $q->whereHas('garasi', fn($g) => $g->where('tipe_garasi', $tipeGarasi)))
            ->when($nik, fn($q) => $q->where('nik', $nik))
            ->orderByDesc('tanggal_mulai')
            ->get();

        // Tentukan jenis tabel rekap berdasarkan filter waktu yang dipilih
        if ($tahun && $bulan) {
            $judulRekap = "Rekap Per Hari (Bulan {$bulan} Tahun {$tahun})";
            $rekap = $this->buildRekap($transaksi, fn(SewaGarasi $s) => $s->tanggal_mulai->format('d-m-y'));
        } elseif ($tahun) {
            $judulRekap = "Rekap Per Bulan (Tahun {$tahun})";
            $rekap = $this->buildRekap($transaksi, fn(SewaGarasi $s) => $s->tanggal_mulai->translatedFormat('F Y'));
        } else {
            $judulRekap = 'Rekap Per Tipe Garasi';
            $rekap = $this->buildRekap($transaksi, fn(SewaGarasi $s) => ucwords($s->garasi->tipe_garasi));
        }

        return [
            'transaksi' => $transaksi,
            'rekap' => $rekap,
            'judul_rekap' => $judulRekap,
            'total_transaksi' => $transaksi->count(),
            'total_pendapatan' => (float) $transaksi->sum('total_biaya'),
        ];
    }

    /**
     * Helper DRY untuk mengelompokkan transaksi dan menghitung subtotal pendapatan.
     */
    private function buildRekap(Collection $transaksi, callable $groupKey): Collection
    {
        return $transaksi->groupBy($groupKey)->map(function (Collection $items, string $label) {
            return [
                'label' => $label,
                'jumlah_transaksi' => $items->count(),
                'total_biaya_sewa' => (float) $items->sum('biaya_sewa'),
                'total_biaya_listrik' => (float) $items->sum('biaya_listrik'),
                'total_pendapatan' => (float) $items->sum('total_biaya'),
            ];
        })->values();
    }
}
