@extends('layouts.app')
@section('title', 'Proses Perpanjangan Sewa')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Perpanjang Sewa: {{ $sewa->sewa_id }}</h1>

        <div class="p-4 bg-gray-50 rounded border text-sm mb-4 space-y-1">
            <div>Garasi: <strong>{{ $sewa->garasi_id }} ({{ $sewa->garasi->tipe_garasi }})</strong></div>
            <div>Penyewa: <strong>{{ $sewa->penyewa->nama_lengkap }}</strong></div>
            <div>Harga Harian: <strong>Rp {{ number_format($sewa->garasi->harga_sewa, 0, ',', '.') }}</strong></div>
            <div>Tanggal Selesai Saat Ini: <strong>{{ $sewa->tanggal_selesai->format('d-m-y') }}</strong></div>
        </div>

        <form action="{{ route('admin.perpanjangan.update', $sewa->sewa_id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tipe Perpanjangan</label>
                    <select name="tipe_perpanjangan" id="tipe_perpanjangan" required class="w-full border rounded px-3 py-2">
                        <option value="harian">Harian</option>
                        <option value="bulanan">Bulanan (25x Harian / Bulan)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" id="label_durasi">Tambah Jumlah Hari</label>
                    <input type="number" name="durasi" id="durasi" value="{{ old('durasi', 1) }}" min="1"
                        required class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="p-4 bg-teal-50 border border-teal-200 rounded text-sm space-y-1">
                <div>Tanggal Selesai Baru: <strong id="preview_tanggal">-</strong></div>
                <div class="text-base">Sisa Biaya Tambahan: <strong id="preview_biaya" class="text-teal-800">Rp 0</strong>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Upload Bukti Bayar Perpanjangan (JPG/PNG)</label>
                <input type="file" name="bukti_bayar" accept="image/*" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-teal-700 text-white px-4 py-2 rounded hover:bg-teal-800">
                    Simpan Perpanjangan
                </button>
                <a href="{{ route('admin.perpanjangan.index') }}" class="px-4 py-2 border rounded hover:bg-gray-100">
                    Kembali
                </a>
            </div>
        </form>

        @if ($sewa->perpanjangan->isNotEmpty())
            <div class="mt-6 border-t pt-4">
                <h2 class="font-semibold text-sm mb-2">Riwayat Perpanjangan Sebelumnya</h2>
                <ul class="text-xs space-y-1 text-gray-600">
                    @foreach ($sewa->perpanjangan as $p)
                        <li>
                            {{ $p->perpanjangan_id }}: {{ $p->tanggal_selesai_lama->format('d-m-y') }} &rarr;
                            {{ $p->tanggal_selesai_baru->format('d-m-y') }}
                            (Rp {{ number_format($p->biaya_tambahan, 0, ',', '.') }})
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <script>
        const hargaHarian = {{ (float) $sewa->garasi->harga_sewa }};
        const tglLamaStr = "{{ $sewa->tanggal_selesai->format('Y-m-d') }}";
        const tipeEl = document.getElementById('tipe_perpanjangan');
        const durasiEl = document.getElementById('durasi');

        function updatePreview() {
            const tipe = tipeEl.value;
            const durasi = parseInt(durasiEl.value || 0, 10);

            document.getElementById('label_durasi').textContent =
                tipe === 'bulanan' ? 'Tambah Jumlah Bulan' : 'Tambah Jumlah Hari';

            if (durasi < 1) return;

            const d = new Date(tglLamaStr + 'T00:00:00');
            if (tipe === 'bulanan') {
                d.setMonth(d.getMonth() + durasi);
            } else {
                d.setDate(d.getDate() + durasi);
            }

            const dd = String(d.getDate()).padStart(2, '0');
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const yy = String(d.getFullYear()).slice(-2);
            document.getElementById('preview_tanggal').textContent = `${dd}-${mm}-${yy}`;

            const biaya = tipe === 'bulanan' ? durasi * 25 * hargaHarian : durasi * hargaHarian;
            document.getElementById('preview_biaya').textContent = 'Rp ' + Math.round(biaya).toLocaleString('id-ID');
        }

        tipeEl.addEventListener('change', updatePreview);
        durasiEl.addEventListener('input', updatePreview);
        updatePreview();
    </script>
@endsection
