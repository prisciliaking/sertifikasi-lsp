<?php

namespace App\Services;

use App\Models\Garasi;
use App\Models\Kendaraan;
use App\Models\SewaGarasi;
use App\Models\User;
use App\Models\PerpanjanganSewa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class SewaService
{
    /**
     * Menghitung tanggal selesai berdasarkan tipe sewa dan aturan kalender.
     *
     * @throws InvalidArgumentException Jika jumlah hari melebihi batas (daysInMonth - 1)
     */
    public function hitungTanggalSelesai(Carbon $tanggalMulai, string $tipeSewa, ?int $jumlahHari = null): Carbon
    {
        if ($tipeSewa === SewaGarasi::TIPE_BULANAN) {
            return $tanggalMulai->copy()->addMonth();
        }

        $maksHari = $tanggalMulai->daysInMonth - 1;
        if (!$jumlahHari || $jumlahHari < 1 || $jumlahHari > $maksHari) {
            throw new InvalidArgumentException(
                "Untuk bulan {$tanggalMulai->translatedFormat('F Y')}, sewa harian maksimal {$maksHari} hari."
            );
        }

        return $tanggalMulai->copy()->addDays($jumlahHari);
    }

    /**
     * Menghitung biaya sewa, biaya listrik (EV), dan total biaya.
     *
     * @return array{biaya_sewa: float, biaya_listrik: float, total_biaya: float}
     */
    public function hitungBiaya(
        Garasi $garasi,
        string $tipeSewa,
        ?int $jumlahHari,
        string $tipeKendaraan,
        ?float $kapasitasBaterai,
        ?float $sisaBateraiAwal
    ): array {
        $biayaSewa = $tipeSewa === SewaGarasi::TIPE_BULANAN
            ? SewaGarasi::MULTIPLIER_BULANAN * (float) $garasi->harga_sewa
            : $jumlahHari * (float) $garasi->harga_sewa;

        $biayaListrik = 0.0;

        if ($tipeKendaraan === Kendaraan::TIPE_MOBIL_LISTRIK && $garasi->tipe_garasi === Garasi::TIPE_MOBIL_LISTRIK) {
            $kwhTerisi = $kapasitasBaterai * ((100 - $sisaBateraiAwal) / 100);
            $biayaListrik = $kwhTerisi * (float) $garasi->harga_per_kwh;
        }

        return [
            'biaya_sewa' => round($biayaSewa, 2),
            'biaya_listrik' => round($biayaListrik, 2),
            'total_biaya' => round($biayaSewa + $biayaListrik, 2),
        ];
    }

    /**
     * Mengambil daftar garasi yang tersedia (tidak bentrok tanggal) pada rentang tertentu.
     */
    public function getAvailableGarasi(string $tipeGarasi, Carbon $tanggalMulai, Carbon $tanggalSelesai): Collection
    {
        $terpakaiIds = SewaGarasi::where('tanggal_mulai', '<=', $tanggalSelesai)
            ->where('tanggal_selesai', '>=', $tanggalMulai)
            ->pluck('garasi_id');

        return Garasi::where('tipe_garasi', $tipeGarasi)
            ->whereNotIn('garasi_id', $terpakaiIds)
            ->orderBy('garasi_id')
            ->get();
    }

    /**
     * Memproses penyimpanan transaksi sewa baru secara atomik.
     */
    public function createSewa(User $user, array $data, UploadedFile $buktiBayar): SewaGarasi
    {
        $garasi = Garasi::findOrFail($data['garasi_id']);

        // 1. Validasi kecocokan tipe kendaraan & garasi
        $allowedGarasi = Kendaraan::allowedTipeGarasi($data['tipe_kendaraan']);
        if (!in_array($garasi->tipe_garasi, $allowedGarasi, true)) {
            throw new InvalidArgumentException('Tipe garasi tidak sesuai dengan tipe kendaraan yang dipilih.');
        }

        // 2. Hitung tanggal selesai & cek bentrok tanggal
        $tanggalMulai = Carbon::parse($data['tanggal_mulai'])->startOfDay();
        $jumlahHari = isset($data['jumlah_hari']) ? (int) $data['jumlah_hari'] : null;
        $tanggalSelesai = $this->hitungTanggalSelesai($tanggalMulai, $data['tipe_sewa'], $jumlahHari);

        $bentrok = SewaGarasi::where('garasi_id', $garasi->garasi_id)
            ->where('tanggal_mulai', '<=', $tanggalSelesai)
            ->where('tanggal_selesai', '>=', $tanggalMulai)
            ->exists();

        if ($bentrok) {
            throw new InvalidArgumentException("Garasi {$garasi->garasi_id} sudah terpakai pada rentang tanggal tersebut.");
        }

        // 3. Hitung biaya
        $biaya = $this->hitungBiaya(
            $garasi,
            $data['tipe_sewa'],
            $jumlahHari,
            $data['tipe_kendaraan'],
            isset($data['kapasitas_baterai']) ? (float) $data['kapasitas_baterai'] : null,
            isset($data['sisa_baterai_awal']) ? (float) $data['sisa_baterai_awal'] : null
        );

        // 4. Upload bukti bayar ke public/assets/img
        $fileName = 'BUKTI-' . now()->format('YmdHis') . '-' . uniqid() . '.' . $buktiBayar->extension();
        $buktiBayar->move(public_path('assets/img'), $fileName);
        $pathBukti = 'assets/img/' . $fileName;

        // 5. Simpan Kendaraan, SewaGarasi, dan update status garasi dalam DB::transaction
        return DB::transaction(function () use ($user, $data, $garasi, $tanggalMulai, $tanggalSelesai, $biaya, $pathBukti) {
            $kendaraan = Kendaraan::create([
                'kendaraan_id' => $this->generateId('KND', Kendaraan::class, 'kendaraan_id'),
                'tipe_kendaraan' => $data['tipe_kendaraan'],
                'kapasitas_baterai' => $data['tipe_kendaraan'] === Kendaraan::TIPE_MOBIL_LISTRIK ? $data['kapasitas_baterai'] : null,
                'plat_nomor' => $data['tipe_kendaraan'] === Kendaraan::TIPE_SEPEDA ? null : $data['plat_nomor'],
                'merek_kendaraan' => $data['merek_kendaraan'],
                'model_merek' => $data['model_merek'],
                'nik' => $user->nik,
            ]);

            $sewa = SewaGarasi::create([
                'sewa_id' => $this->generateId('SEWA', SewaGarasi::class, 'sewa_id'),
                'nik' => $user->nik,
                'kendaraan_id' => $kendaraan->kendaraan_id,
                'garasi_id' => $garasi->garasi_id,
                'tipe_sewa' => $data['tipe_sewa'],
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'sisa_baterai_awal' => $garasi->tipe_garasi === Garasi::TIPE_MOBIL_LISTRIK ? $data['sisa_baterai_awal'] : null,
                'biaya_sewa' => $biaya['biaya_sewa'],
                'biaya_listrik' => $biaya['biaya_listrik'],
                'total_biaya' => $biaya['total_biaya'],
                'bukti_bayar' => $pathBukti,
            ]);

            // Update status garasi menjadi used
            $garasi->update(['status_sewa' => true]);

            return $sewa;
        });
    }

    /**
     * Helper DRY untuk men-generate ID custom: PREFIX-YYYYMMDD-001.
     */
    private function generateId(string $prefix, string $modelClass, string $column): string
    {
        $datePart = now()->format('Ymd');
        $base = "{$prefix}-{$datePart}-";

        $lastId = $modelClass::where($column, 'like', "{$base}%")
            ->orderByDesc($column)
            ->value($column);

        $nextNumber = $lastId ? ((int) substr($lastId, -3)) + 1 : 1;

        return $base . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Menghitung tanggal selesai baru dan biaya tambahan untuk perpanjangan oleh Admin.
     * Admin tidak dibatasi durasi (bebas berapa hari atau berapa bulan).
     *
     * @return array{tanggal_selesai_baru: Carbon, biaya_tambahan: float}
     */
    public function hitungPerpanjangan(SewaGarasi $sewa, string $tipePerpanjangan, int $durasi): array
    {
        if ($durasi < 1) {
            throw new InvalidArgumentException('Durasi perpanjangan minimal 1.');
        }

        $tanggalLama = $sewa->tanggal_selesai->copy();
        $hargaHarian = (float)$sewa->garasi->harga_sewa;

        if ($tipePerpanjangan === SewaGarasi::TIPE_BULANAN) {
            $tanggalBaru = $tanggalLama->copy()->addMonths($durasi);
            $biayaTambahan = $durasi * SewaGarasi::MULTIPLIER_BULANAN * $hargaHarian;
        } else {
            $tanggalBaru = $tanggalLama->copy()->addDays($durasi);
            $biayaTambahan = $durasi * $hargaHarian;
        }

        return [
            'tanggal_selesai_baru' => $tanggalBaru,
            'biaya_tambahan' => round($biayaTambahan, 2),
        ];
    }

    /**
     * Memproses perpanjangan sewa: cek bentrok, upload bukti, catat histori, dan update sewa utama.
     */
    public function extendSewa(
        SewaGarasi $sewa,
        User $admin,
        string $tipePerpanjangan,
        int $durasi,
        UploadedFile $buktiBayar
    ): PerpanjanganSewa {
        $hasil = $this->hitungPerpanjangan($sewa, $tipePerpanjangan, $durasi);
        $tanggalLama = $sewa->tanggal_selesai->copy();
        $tanggalBaru = $hasil['tanggal_selesai_baru'];

        // Cek apakah rentang perpanjangan bentrok dengan sewa lain di garasi yang sama
        $bentrok = SewaGarasi::where('garasi_id', $sewa->garasi_id)
            ->where('sewa_id', '!=', $sewa->sewa_id)
            ->where('tanggal_mulai', '<=', $tanggalBaru)
            ->where('tanggal_selesai', '>=', $tanggalLama)
            ->exists();

        if ($bentrok) {
            throw new InvalidArgumentException(
                "Garasi {$sewa->garasi_id} sudah dipesan orang lain pada rentang perpanjangan tersebut."
            );
        }

        // Upload bukti bayar ke public/assets/img
        $fileName = 'PNJ-' . now()->format('YmdHis') . '-' . uniqid() . '.' . $buktiBayar->extension();
        $buktiBayar->move(public_path('assets/img'), $fileName);
        $pathBukti = 'assets/img/' . $fileName;

        return DB::transaction(function () use ($sewa, $admin, $tanggalLama, $tanggalBaru, $hasil, $pathBukti) {
            $perpanjangan = PerpanjanganSewa::create([
                'perpanjangan_id' => $this->generateId('PNJ', PerpanjanganSewa::class, 'perpanjangan_id'),
                'sewa_id' => $sewa->sewa_id,
                'tanggal_selesai_lama' => $tanggalLama,
                'tanggal_selesai_baru' => $tanggalBaru,
                'biaya_tambahan' => $hasil['biaya_tambahan'],
                'bukti_bayar' => $pathBukti,
                'admin_nik' => $admin->nik,
            ]);

            // Update tanggal selesai dan akumulasi biaya di tabel sewa_garasi
            $sewa->update([
                'tanggal_selesai' => $tanggalBaru,
                'biaya_sewa' => (float) $sewa->biaya_sewa + $hasil['biaya_tambahan'],
                'total_biaya' => (float) $sewa->total_biaya + $hasil['biaya_tambahan'],
            ]);

            return $perpanjangan;
        });
    }
}
