@extends('layouts.app')
@section('title', 'Proses Perpanjangan Sewa')

@section('content')
    <div class="max-w-3xl mx-auto space-y-5">

        {{-- Header Halaman --}}
        <div>
            <a href="{{ route('admin.perpanjangan.index') }}"
                class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 hover:text-slate-800 mb-2 transition">
                <i class="bx bx-arrow-left-stroke text-lg"></i>
                <span>Kembali ke Daftar Sewa Aktif</span>
            </a>
            <div class="flex flex-wrap items-baseline gap-2.5">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-800">
                    Perpanjang Sewa
                </h1>
                <span class="font-mono text-sm font-bold text-slate-500">
                    #{{ $sewa->sewa_id }}
                </span>
            </div>
        </div>

        {{-- Kartu Utama --}}
        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-3xl shadow-soft overflow-hidden">
            {{-- Garis Aksen Pastel --}}
            <div class="h-1.5 w-full bg-gradient-to-r from-pastel-cream via-pastel-pink to-pastel-blue"></div>

            <div class="p-5 sm:p-6 space-y-6">

                {{-- Ringkasan Detail Sewa (Ringkas & Bersih) --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Garasi</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $sewa->garasi_id }}</p>
                        <p class="text-xs text-slate-500 capitalize">{{ $sewa->garasi->tipe_garasi }}</p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Penyewa</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5 truncate"
                            title="{{ $sewa->penyewa->nama_lengkap }}">
                            {{ $sewa->penyewa->nama_lengkap }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Harga Harian</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">
                            Rp {{ number_format($sewa->garasi->harga_sewa, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Selesai Saat Ini</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">
                            {{ $sewa->tanggal_selesai->format('d-m-y') }}
                        </p>
                    </div>
                </div>

                {{-- Formulir Perpanjangan --}}
                <form action="{{ route('admin.perpanjangan.update', $sewa->sewa_id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Tipe Perpanjangan --}}
                        {{-- Tipe Perpanjangan --}}
                        <div>
                            <label for="tipe_perpanjangan"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Tipe Perpanjangan
                            </label>
                            <div class="relative">
                                {{-- Ikon Kiri (Boxicons v3) --}}
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-clock-3 text-lg"></i>
                                </span>

                                <select name="tipe_perpanjangan" id="tipe_perpanjangan" required
                                    class="w-full appearance-none pl-10 pr-10 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition cursor-pointer">
                                    <option value="harian">Harian</option>
                                    <option value="bulanan">Bulanan</option>
                                </select>

                                {{-- Ikon Panah Kanan Kustom --}}
                                <span
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-chevron-down text-lg"></i>
                                </span>
                            </div>
                        </div>

                        {{-- Durasi --}}
                        <div>
                            <label for="durasi" id="label_durasi"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Tambah Jumlah Hari
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-plus-circle text-lg"></i>
                                </span>
                                <input type="number" name="durasi" id="durasi" value="{{ old('durasi', 1) }}"
                                    min="1" required
                                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-semibold focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition">
                            </div>
                        </div>
                    </div>

                    {{-- Pratinjau Perhitungan --}}
                    <div
                        class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-pastel-blue/35 via-pastel-cream/30 to-pastel-pink/25 border border-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-white/90 flex items-center justify-center text-slate-700 shrink-0 shadow-xs">
                                <i class="bx bx-calendar-check text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500">Tanggal Selesai Baru</p>
                                <p id="preview_tanggal" class="text-base font-extrabold text-slate-800">-</p>
                            </div>
                        </div>

                        <div class="sm:text-right border-t sm:border-t-0 pt-3 sm:pt-0 border-white/70">
                            <p class="text-xs font-semibold text-slate-500">Biaya Tambahan</p>
                            <p id="preview_biaya" class="text-xl font-extrabold text-slate-900 tracking-tight">Rp 0</p>
                        </div>
                    </div>

                    {{-- Unggah Bukti Pembayaran --}}
                    <div>
                        <label for="bukti_bayar"
                            class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Unggah Bukti Pembayaran Perpanjangan (JPG/PNG)
                        </label>
                        <input id="bukti_bayar" type="file" name="bukti_bayar" accept="image/*" required
                            class="w-full text-xs text-slate-600 bg-white/90 border border-dashed border-slate-300 rounded-2xl p-2.5
                            file:mr-3 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold
                            file:bg-pastel-cream file:text-slate-800 hover:file:bg-[#f6e1aa] file:cursor-pointer
                            focus:outline-none focus:ring-4 focus:ring-pastel-cream/60 transition cursor-pointer">
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex flex-wrap items-center gap-2.5 pt-1">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-full bg-pastel-blue hover:bg-[#b5d4ec] text-slate-800 font-bold text-sm shadow-sm hover:shadow transition-all duration-200 active:scale-95 cursor-pointer">
                            <span>Simpan</span>
                        </button>
                        <a href="{{ route('admin.perpanjangan.index') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 rounded-full bg-white hover:bg-slate-50 border border-slate-200/80 text-slate-600 font-semibold text-sm transition">
                            Kembali
                        </a>
                    </div>
                </form>

                {{-- Riwayat Perpanjangan Sebelumnya --}}
                @if ($sewa->perpanjangan->isNotEmpty())
                    <div class="pt-5 border-t border-slate-100">
                        <div class="flex items-center gap-1.5 mb-3">
                            <i class="bx bx-history text-base text-slate-400"></i>
                            <h2 class="font-bold text-sm text-slate-800">Riwayat Perpanjangan Sebelumnya</h2>
                        </div>
                        <div class="divide-y divide-slate-100 border border-slate-100 rounded-2xl px-4 bg-white/60">
                            @foreach ($sewa->perpanjangan as $p)
                                <div class="flex flex-wrap items-center justify-between gap-2 py-2.5 text-xs">
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono font-bold text-slate-700">
                                            {{ $p->perpanjangan_id }}
                                        </span>
                                        <span class="text-slate-600">
                                            {{ $p->tanggal_selesai_lama->format('d-m-y') }}
                                            <i
                                                class="bx bx-arrow-right-stroke text-sm align-middle text-slate-400 mx-0.5"></i>
                                            <strong
                                                class="text-slate-800">{{ $p->tanggal_selesai_baru->format('d-m-y') }}</strong>
                                        </span>
                                    </div>
                                    <span class="font-bold text-slate-800">
                                        Rp {{ number_format($p->biaya_tambahan, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
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
