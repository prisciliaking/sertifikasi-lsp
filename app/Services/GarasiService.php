<?php

namespace App\Services;

use App\Models\Garasi;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class GarasiService
{
    /**
     * Membuat sejumlah garasi baru secara berkelompok dengan ID incremental 3 digit.
     *
     * @param array $data Data tervalidasi (tipe_garasi, jumlah, harga_sewa, harga_per_kwh)
     * @return int Jumlah garasi yang berhasil dibuat
     * @throws InvalidArgumentException Jika total unit melebihi batas maksimal 999
     */
    public function createBatch(array $data): int
    {
        $tipe = $data['tipe_garasi'];
        $jumlah = (int) $data['jumlah'];
        $prefix = Garasi::PREFIX_MAP[$tipe];

        // Cari nomor urut terakhir untuk tipe garasi ini
        $lastId = Garasi::where('tipe_garasi', $tipe)
            ->orderByDesc('garasi_id')
            ->value('garasi_id');

        $lastNumber = $lastId ? (int) substr($lastId, 1) : 0;

        // Guard clause: pastikan tidak melebihi batas 999 unit per tipe
        if (($lastNumber + $jumlah) > Garasi::MAX_UNIT_PER_TIPE) {
            $sisaSlot = Garasi::MAX_UNIT_PER_TIPE - $lastNumber;
            throw new InvalidArgumentException(
                "Gagal! Sisa kuota untuk tipe {$tipe} hanya {$sisaSlot} unit (maksimal 999)."
            );
        }

        $now = now();
        $hargaKwh = $tipe === Garasi::TIPE_MOBIL_LISTRIK ? $data['harga_per_kwh'] : null;
        $rows = [];

        for ($i = 1; $i <= $jumlah; $i++) {
            $nextNumber = $lastNumber + $i;
            $rows[] = [
                'garasi_id' => $prefix . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT),
                'tipe_garasi' => $tipe,
                'harga_sewa' => $data['harga_sewa'],
                'harga_per_kwh' => $hargaKwh,
                'status_sewa' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Bulk insert di dalam transaction agar cepat dan atomik
        DB::transaction(fn() => Garasi::insert($rows));

        return $jumlah;
    }
}
