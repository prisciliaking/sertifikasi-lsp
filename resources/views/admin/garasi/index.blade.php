@extends('layouts.app')
@section('title', 'Kelola Garasi')

@section('content')
    <div class="space-y-5">

        {{-- Header Halaman & Keterangan Tanggal Hari Ini --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-800">
                    Kelola Garasi
                </h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Tambahkan unit garasi secara massal dan pantau jadwal ketersediaan tiap unit.
                </p>
            </div>

            {{-- Keterangan Tanggal Hari Ini --}}
            <div
                class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white/85 backdrop-blur-md border border-white shadow-soft self-start sm:self-auto">
                <div class="w-7 h-7 rounded-full bg-pastel-cream flex items-center justify-center text-slate-700 shrink-0">
                    <i class="bx bx-calendar text-base"></i>
                </div>
                <div class="text-xs leading-tight">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Hari Ini</span>
                    <span class="font-bold text-slate-700">
                        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- 1. BAGIAN ATAS: BUAT GARASI BARU --}}
        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-3xl shadow-soft overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-pastel-pink via-pastel-cream to-pastel-blue"></div>

            <div class="p-5 sm:p-6">
                <div class="flex items-center gap-2.5 mb-4">
                    <div
                        class="w-9 h-9 rounded-full bg-pastel-pink/55 flex items-center justify-center text-slate-800 shrink-0">
                        <i class="bx bx-plus-circle text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-800 leading-tight">Buat Garasi Baru</h2>
                        <p class="text-xs text-slate-500">Pembuatan unit otomatis secara massal</p>
                    </div>
                </div>

                <form action="{{ route('admin.garasi.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 items-end">
                        {{-- Tipe Garasi --}}
                        <div>
                            <label for="tipe_garasi"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Tipe Garasi
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-car text-lg"></i>
                                </span>
                                <select name="tipe_garasi" id="tipe_garasi" required
                                    class="w-full pl-10 pr-4 py-2 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition">
                                    <option value="sepeda" {{ old('tipe_garasi') == 'sepeda' ? 'selected' : '' }}>
                                        Sepeda / Motor (S)
                                    </option>
                                    <option value="mobil" {{ old('tipe_garasi') == 'mobil' ? 'selected' : '' }}>
                                        Mobil (C)
                                    </option>
                                    <option value="mobil listrik"
                                        {{ old('tipe_garasi') == 'mobil listrik' ? 'selected' : '' }}>
                                        Mobil Listrik (E)
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- Jumlah Garasi --}}
                        <div>
                            <label for="jumlah"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Jumlah Unit (Maks. 999)
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-layer text-lg"></i>
                                </span>
                                <input id="jumlah" type="number" name="jumlah" value="{{ old('jumlah', 1) }}"
                                    min="1" max="999" required
                                    class="w-full pl-10 pr-4 py-2 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-semibold focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition">
                            </div>
                        </div>

                        {{-- Harga Sewa Harian --}}
                        <div>
                            <label for="harga_sewa"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Harga Sewa Harian (Rp)
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-wallet text-lg"></i>
                                </span>
                                <input id="harga_sewa" type="number" name="harga_sewa" value="{{ old('harga_sewa') }}"
                                    min="0" required placeholder="Contoh: 25000"
                                    class="w-full pl-10 pr-4 py-2 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-semibold placeholder:font-normal placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition">
                            </div>
                        </div>

                        {{-- Tombol Buat --}}
                        <div>
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-1.5 py-2.5 px-5 rounded-full bg-pastel-blue hover:bg-[#b5d4ec] text-slate-800 font-bold text-sm shadow-sm hover:shadow transition-all duration-200 active:scale-95 cursor-pointer">
                                <i class="bx bx-plus text-lg"></i>
                                <span>Buat Garasi</span>
                            </button>
                        </div>
                    </div>

                    {{-- Input Kondisional: Harga Listrik per kWh --}}
                    <div id="kwh_wrapper"
                        class="hidden p-3.5 rounded-2xl bg-pastel-cream/50 border border-pastel-cream max-w-md">
                        <label for="harga_per_kwh"
                            class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Harga Isi Daya Listrik / kWh (Rp)
                        </label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500 pointer-events-none">
                                <i class="bx bx-bolt text-lg"></i>
                            </span>
                            <input type="number" name="harga_per_kwh" id="harga_per_kwh" value="{{ old('harga_per_kwh') }}"
                                min="0" placeholder="Contoh: 2500"
                                class="w-full pl-10 pr-4 py-2 text-sm bg-white border border-white rounded-full text-slate-800 font-semibold placeholder:font-normal placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-cream focus:border-pastel-cream transition">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- 2. BAGIAN BAWAH: DAFTAR GARASI --}}
        <div class="space-y-4">
            {{-- Header Daftar + Navbar Filter Tipe --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <div
                        class="w-9 h-9 rounded-full bg-pastel-blue/60 flex items-center justify-center text-slate-800 shrink-0">
                        <i class="bx bx-home-alt text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-800 leading-tight">Daftar Garasi</h2>
                        <p class="text-xs text-slate-500">
                            Total {{ $garasiList->total() }} unit &bull; Klik kartu garasi untuk melihat kalender
                            ketersediaan
                        </p>
                    </div>
                </div>

                {{-- Navbar Filter: Semua | Sepeda | Mobil | Mobil Listrik --}}
                <nav aria-label="Filter Tipe Garasi"
                    class="inline-flex flex-wrap items-center gap-1 bg-white/80 backdrop-blur-md p-1.5 rounded-full border border-white shadow-soft text-xs font-bold">
                    <a href="{{ route('admin.garasi.index') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full transition-all duration-200 {{ empty($filterTipe) ? 'bg-pastel-blue text-slate-900 shadow-xs' : 'text-slate-600 hover:bg-pastel-cream/60 hover:text-slate-900' }}">
                        <span>Semua</span>
                    </a>
                    <a href="{{ route('admin.garasi.index', ['tipe' => 'sepeda']) }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full transition-all duration-200 {{ $filterTipe == 'sepeda' ? 'bg-pastel-blue text-slate-900 shadow-xs' : 'text-slate-600 hover:bg-pastel-cream/60 hover:text-slate-900' }}">
                        <i class="bx bx-cycling text-sm"></i>
                        <span>Sepeda</span>
                    </a>
                    <a href="{{ route('admin.garasi.index', ['tipe' => 'mobil']) }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full transition-all duration-200 {{ $filterTipe == 'mobil' ? 'bg-pastel-blue text-slate-900 shadow-xs' : 'text-slate-600 hover:bg-pastel-cream/60 hover:text-slate-900' }}">
                        <i class="bx bx-car text-sm"></i>
                        <span>Mobil</span>
                    </a>
                    <a href="{{ route('admin.garasi.index', ['tipe' => 'mobil listrik']) }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full transition-all duration-200 {{ $filterTipe == 'mobil listrik' ? 'bg-pastel-blue text-slate-900 shadow-xs' : 'text-slate-600 hover:bg-pastel-cream/60 hover:text-slate-900' }}">
                        <i class="bx bx-bolt text-sm"></i>
                        <span>Mobil Listrik</span>
                    </a>
                </nav>
            </div>

            {{-- Grid Card Garasi --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($garasiList as $g)
                    @php
                        $hariIni = \Carbon\Carbon::today();
                        $daftarSewa = $g->sewaGarasi ?? collect();

                        // Cek apakah sedang dipakai HARI INI
                        $sewaHariIni = $daftarSewa->first(function ($s) use ($hariIni) {
                            return $hariIni->between(
                                \Carbon\Carbon::parse($s->tanggal_mulai)->startOfDay(),
                                \Carbon\Carbon::parse($s->tanggal_selesai)->startOfDay(),
                            );
                        });

                        $sedangTerpakai = (bool) $sewaHariIni;

                        $jadwalJson = $daftarSewa
                            ->map(function ($s) {
                                return [
                                    'mulai' => \Carbon\Carbon::parse($s->tanggal_mulai)->format('Y-m-d'),
                                    'selesai' => \Carbon\Carbon::parse($s->tanggal_selesai)->format('Y-m-d'),
                                    'mulai_ui' => \Carbon\Carbon::parse($s->tanggal_mulai)->format('d-m-y'),
                                    'selesai_ui' => \Carbon\Carbon::parse($s->tanggal_selesai)->format('d-m-y'),
                                    'penyewa' => optional($s->penyewa)->nama_lengkap ?? 'Penyewa',
                                ];
                            })
                            ->values();
                    @endphp

                    <button type="button" data-id="{{ $g->garasi_id }}" data-tipe="{{ ucwords($g->tipe_garasi) }}"
                        data-used="{{ $sedangTerpakai ? '1' : '0' }}" data-harga="{{ (float) $g->harga_sewa }}"
                        data-kwh="{{ $g->harga_per_kwh ? (float) $g->harga_per_kwh : '' }}"
                        data-jadwal="{{ json_encode($jadwalJson) }}" onclick="bukaModalJadwal(this)"
                        class="text-left group bg-white/80 backdrop-blur-xl border border-white rounded-2xl shadow-soft overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 cursor-pointer flex flex-col justify-between">

                        {{-- Garis Aksen Status --}}
                        <div class="h-1 w-full {{ $sedangTerpakai ? 'bg-pastel-pink' : 'bg-pastel-blue' }}"></div>

                        <div class="p-4 space-y-3 w-full">
                            {{-- Baris Atas: ID & Status --}}
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-9 h-9 rounded-full {{ $sedangTerpakai ? 'bg-pastel-pink/50' : 'bg-pastel-blue/50' }} flex items-center justify-center text-slate-800 shrink-0 group-hover:scale-105 transition-transform">
                                        @if ($g->tipe_garasi === 'mobil listrik')
                                            <i class="bx bx-bolt text-lg"></i>
                                        @elseif ($g->tipe_garasi === 'mobil')
                                            <i class="bx bx-car text-lg"></i>
                                        @else
                                            <i class="bx bx-cycling text-lg"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="font-mono text-sm font-extrabold text-slate-800 block leading-tight">
                                            {{ $g->garasi_id }}
                                        </span>
                                        <span class="text-[11px] font-semibold text-slate-500 capitalize">
                                            {{ $g->tipe_garasi }}
                                        </span>
                                    </div>
                                </div>

                                @if ($sedangTerpakai)
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-pastel-pink/75 text-slate-800 text-[10px] font-bold uppercase tracking-wide shrink-0">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-700"></span>
                                        Terpakai
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-pastel-blue/75 text-slate-800 text-[10px] font-bold uppercase tracking-wide shrink-0">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-700"></span>
                                        Tersedia
                                    </span>
                                @endif
                            </div>

                            {{-- Detail Harga --}}
                            <div class="px-3 py-2 rounded-xl bg-slate-50/85 border border-slate-100 space-y-1">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-500">Harga Harian</span>
                                    <span class="font-bold text-slate-800">
                                        Rp {{ number_format($g->harga_sewa, 0, ',', '.') }}
                                    </span>
                                </div>
                                @if ($g->harga_per_kwh)
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-slate-500">Isi Daya / kWh</span>
                                        <span class="font-bold text-slate-700">
                                            Rp {{ number_format($g->harga_per_kwh, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Info Singkat Jadwal Aktif / Mendatang --}}
                            @if ($sewaHariIni)
                                <div
                                    class="text-[11px] font-semibold text-rose-700 bg-pastel-pink/35 px-2.5 py-1.5 rounded-xl flex items-center justify-between gap-2">
                                    <span>Terpakai s/d</span>
                                    <span
                                        class="font-mono font-bold">{{ \Carbon\Carbon::parse($sewaHariIni->tanggal_selesai)->format('d-m-y') }}</span>
                                </div>
                            @elseif ($daftarSewa->isNotEmpty())
                                <div
                                    class="text-[11px] font-semibold text-amber-800 bg-pastel-cream/75 px-2.5 py-1.5 rounded-xl flex items-center justify-between gap-2">
                                    <span>Dibooking mulai</span>
                                    <span
                                        class="font-mono font-bold">{{ \Carbon\Carbon::parse($daftarSewa->first()->tanggal_mulai)->format('d-m-y') }}</span>
                                </div>
                            @endif

                            {{-- Footer Kartu: Ajakan Klik --}}
                            <div
                                class="flex items-center justify-between pt-0.5 text-[11px] font-bold text-slate-500 group-hover:text-slate-800 transition-colors">
                                <span class="inline-flex items-center gap-1">
                                    <i class="bx bx-calendar text-sm"></i>
                                    Lihat Kalender Jadwal
                                </span>
                                <i
                                    class="bx bx-chevron-right text-base transition-transform group-hover:translate-x-0.5"></i>
                            </div>
                        </div>
                    </button>
                @empty
                    <div
                        class="col-span-full bg-white/80 backdrop-blur-xl border border-white rounded-2xl shadow-soft py-12 px-6 text-center">
                        <div
                            class="w-14 h-14 mx-auto mb-3 rounded-full bg-pastel-cream/70 flex items-center justify-center text-slate-500">
                            <i class="bx bx-home-alt text-3xl"></i>
                        </div>
                        <p class="font-bold text-slate-700 text-sm">Belum ada data garasi</p>
                        <p class="text-xs text-slate-400 mt-1">
                            Gunakan formulir di atas untuk membuat unit garasi baru.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- Paginasi --}}
            @if ($garasiList->hasPages())
                <div class="bg-white/75 backdrop-blur-md border border-white rounded-2xl px-4 py-3 shadow-soft">
                    {{ $garasiList->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL KALENDER KETERSEDIAAN GARASI --}}
    @push('modals')
        <div id="modal-jadwal" class="hidden fixed inset-0 z-[100] overflow-y-auto bg-slate-900/40 backdrop-blur-xs">
            <div class="min-h-screen flex items-center justify-center p-4">
                <div
                    class="w-full max-w-md my-auto bg-white/95 backdrop-blur-xl border border-white rounded-3xl shadow-xl overflow-hidden animate-fade-up">
                    <div class="h-1.5 w-full bg-gradient-to-r from-pastel-blue via-pastel-cream to-pastel-pink"></div>

                    <div class="p-5 sm:p-6 space-y-4">
                        {{-- Header Modal --}}
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 id="modal-garasi-id" class="text-lg font-extrabold text-slate-800 font-mono">-</h3>
                                    <span id="modal-status-badge"
                                        class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide">-</span>
                                </div>
                                <p id="modal-garasi-info" class="text-xs text-slate-500 mt-0.5">-</p>
                            </div>
                            <button type="button" onclick="tutupModalJadwal()" title="Tutup"
                                class="w-8 h-8 rounded-full bg-slate-100 hover:bg-pastel-pink/60 flex items-center justify-center text-slate-600 transition cursor-pointer">
                                <i class="bx bx-x text-xl"></i>
                            </button>
                        </div>

                        {{-- Navigasi Bulan Kalender --}}
                        <div
                            class="flex items-center justify-between px-2 py-1.5 rounded-full bg-slate-50 border border-slate-100">
                            <button type="button" onclick="ubahBulan(-1)"
                                class="w-8 h-8 rounded-full hover:bg-white flex items-center justify-center text-slate-600 transition cursor-pointer">
                                <i class="bx bx-chevron-left text-xl"></i>
                            </button>
                            <span id="kalender-bulan-label" class="text-sm font-extrabold text-slate-800">-</span>
                            <button type="button" onclick="ubahBulan(1)"
                                class="w-8 h-8 rounded-full hover:bg-white flex items-center justify-center text-slate-600 transition cursor-pointer">
                                <i class="bx bx-chevron-right text-xl"></i>
                            </button>
                        </div>

                        {{-- Grid Kalender --}}
                        <div>
                            <div class="grid grid-cols-7 gap-1 text-center text-[11px] font-bold text-slate-400 mb-1.5">
                                <div>Min</div>
                                <div>Sen</div>
                                <div>Sel</div>
                                <div>Rab</div>
                                <div>Kam</div>
                                <div>Jum</div>
                                <div>Sab</div>
                            </div>
                            <div id="kalender-grid" class="grid grid-cols-7 gap-1.5 text-center text-xs"></div>
                        </div>

                        {{-- Legenda Status --}}
                        <div
                            class="flex flex-wrap items-center justify-center gap-3 pt-2 border-t border-slate-100 text-[11px] font-semibold text-slate-600">
                            <span class="inline-flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-pastel-pink border border-pink-200"></span>
                                Terpakai
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-pastel-blue/70 border border-blue-200"></span>
                                Tersedia
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-pastel-cream ring-2 ring-slate-400"></span>
                                Hari Ini
                            </span>
                        </div>

                        {{-- Ringkasan Rentang Tanggal Terpakai --}}
                        <div id="daftar-periode-box"
                            class="hidden p-3 rounded-2xl bg-pastel-pink/25 border border-pastel-pink/50 space-y-1.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600">Jadwal Terpakai</p>
                            <ul id="daftar-periode-list" class="text-xs text-slate-700 space-y-1.5"></ul>
                        </div>

                        <button type="button" onclick="tutupModalJadwal()"
                            class="w-full py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    <script>
        // Toggle Input Harga kWh
        const tipeSelect = document.getElementById('tipe_garasi');
        const kwhWrapper = document.getElementById('kwh_wrapper');
        const kwhInput = document.getElementById('harga_per_kwh');

        function toggleKwhField() {
            const isListrik = tipeSelect.value === 'mobil listrik';
            kwhWrapper.classList.toggle('hidden', !isListrik);
            kwhInput.required = isListrik;
        }

        tipeSelect.addEventListener('change', toggleKwhField);
        toggleKwhField();

        // Logika Modal Kalender Ketersediaan
        const namaBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        let kalenderTahun = new Date().getFullYear();
        let kalenderBulan = new Date().getMonth();
        let jadwalAktif = [];

        function getTodayLocalStr() {
            const today = new Date();
            return `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
        }

        function bukaModalJadwal(btn) {
            const id = btn.dataset.id;
            const tipe = btn.dataset.tipe;
            const isUsed = btn.dataset.used === '1';
            const harga = Number(btn.dataset.harga || 0);
            const hargaKwh = btn.dataset.kwh ? Number(btn.dataset.kwh) : null;
            jadwalAktif = JSON.parse(btn.dataset.jadwal || '[]');

            document.getElementById('modal-garasi-id').textContent = id;

            let info = `${tipe} • Rp ${Math.round(harga).toLocaleString('id-ID')}/hari`;
            if (hargaKwh) {
                info += ` • Rp ${Math.round(hargaKwh).toLocaleString('id-ID')}/kWh`;
            }
            document.getElementById('modal-garasi-info').textContent = info;

            const badge = document.getElementById('modal-status-badge');
            badge.textContent = isUsed ? 'Terpakai' : 'Tersedia';
            badge.className = isUsed ?
                'px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-pastel-pink/80 text-slate-800' :
                'px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-pastel-blue/80 text-slate-800';

            const now = new Date();
            kalenderTahun = now.getFullYear();
            kalenderBulan = now.getMonth();

            renderKalender();
            renderDaftarPeriode();

            document.getElementById('modal-jadwal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function tutupModalJadwal() {
            document.getElementById('modal-jadwal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function ubahBulan(delta) {
            kalenderBulan += delta;
            if (kalenderBulan < 0) {
                kalenderBulan = 11;
                kalenderTahun--;
            } else if (kalenderBulan > 11) {
                kalenderBulan = 0;
                kalenderTahun++;
            }
            renderKalender();
        }

        function cariBookingTanggal(dateStr) {
            return jadwalAktif.find(item => dateStr >= item.mulai && dateStr <= item.selesai);
        }

        function renderKalender() {
            document.getElementById('kalender-bulan-label').textContent = `${namaBulan[kalenderBulan]} ${kalenderTahun}`;
            const grid = document.getElementById('kalender-grid');
            grid.innerHTML = '';

            const firstDay = new Date(kalenderTahun, kalenderBulan, 1).getDay();
            const daysInMonth = new Date(kalenderTahun, kalenderBulan + 1, 0).getDate();
            const todayStr = getTodayLocalStr();

            for (let i = 0; i < firstDay; i++) {
                grid.innerHTML += '<div></div>';
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dateStr =
                    `${kalenderTahun}-${String(kalenderBulan + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const booking = cariBookingTanggal(dateStr);
                const used = Boolean(booking);
                const isToday = dateStr === todayStr;

                let cellClass = '';
                if (used) {
                    cellClass = 'bg-pastel-pink/85 text-slate-900 font-bold';
                } else if (isToday) {
                    cellClass = 'bg-pastel-cream text-slate-900 font-bold';
                } else {
                    cellClass = 'bg-pastel-blue/35 text-slate-700 font-medium hover:bg-pastel-blue/60';
                }

                if (isToday) {
                    cellClass += ' ring-2 ring-slate-600 ring-offset-1';
                }

                const statusText = used ? `Terpakai (${booking.penyewa})` : 'Tersedia';
                const todayLabel = isToday ? ' • Hari Ini' : '';

                grid.innerHTML += `
                    <div title="${day} ${namaBulan[kalenderBulan]} ${kalenderTahun}: ${statusText}${todayLabel}"
                        class="h-8 rounded-full flex items-center justify-center transition ${cellClass}">
                        ${day}
                    </div>
                `;
            }
        }

        function renderDaftarPeriode() {
            const box = document.getElementById('daftar-periode-box');
            const list = document.getElementById('daftar-periode-list');
            list.innerHTML = '';

            if (jadwalAktif.length === 0) {
                box.classList.add('hidden');
                return;
            }

            box.classList.remove('hidden');
            jadwalAktif.forEach(item => {
                const li = document.createElement('li');
                li.className = 'flex items-center justify-between gap-2';
                li.innerHTML = `
                    <span class="font-semibold truncate">${item.penyewa}</span>
                    <span class="font-mono text-[11px] px-2 py-0.5 rounded-full bg-white/80 shrink-0">${item.mulai_ui} s/d ${item.selesai_ui}</span>
                `;
                list.appendChild(li);
            });
        }

        // Tutup modal jika klik area backdrop atau tekan Esc
        document.getElementById('modal-jadwal').addEventListener('click', (e) => {
            if (e.target === e.currentTarget || e.target === e.currentTarget.firstElementChild) {
                tutupModalJadwal();
            }
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') tutupModalJadwal();
        });
    </script>
@endsection
