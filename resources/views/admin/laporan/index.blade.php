@extends('layouts.app')
@section('title', 'Laporan Sewa Garasi')

@section('content')
    <div class="space-y-5">

        {{-- Header Halaman --}}
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-800">
                Laporan Sewa Garasi
            </h1>
            <p class="text-sm text-slate-500 mt-0.5">
                Pantau rekapitulasi pendapatan dan detail transaksi berdasarkan periode, tipe garasi, maupun penyewa.
            </p>
        </div>

        {{-- Filter 4 Kategori --}}
        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-3xl shadow-soft overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-pastel-cream via-pastel-pink to-pastel-blue"></div>

            <div class="p-5 sm:p-6">
                <div class="flex items-center gap-2.5 mb-4">
                    <div
                        class="w-8 h-8 rounded-full bg-pastel-cream/80 flex items-center justify-center text-slate-700 shrink-0">
                        <i class="bx bx-filter-alt text-lg"></i>
                    </div>
                    <h2 class="text-sm font-extrabold text-slate-800">Saring Laporan</h2>
                </div>

                <form method="GET" action="{{ route('admin.laporan.index') }}"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 items-end">

                    {{-- 1. Filter Tahun --}}
                    <div>
                        <label for="tahun"
                            class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Tahun
                        </label>
                        <div class="relative">
                            <select id="tahun" name="tahun"
                                class="w-full appearance-none pl-4 pr-10 py-2 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition cursor-pointer">
                                <option value="">Semua Tahun</option>
                                @foreach ($daftarTahun as $thn)
                                    <option value="{{ $thn }}"
                                        {{ ($filters['tahun'] ?? '') == $thn ? 'selected' : '' }}>
                                        {{ $thn }}
                                    </option>
                                @endforeach
                            </select>
                            <span
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="bx bx-chevron-down text-lg"></i>
                            </span>
                        </div>
                    </div>

                    {{-- 2. Filter Bulan --}}
                    <div>
                        <label for="bulan"
                            class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Bulan
                        </label>
                        <div class="relative">
                            <select id="bulan" name="bulan"
                                class="w-full appearance-none pl-4 pr-10 py-2 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition cursor-pointer">
                                <option value="">Semua Bulan</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}"
                                        {{ ($filters['bulan'] ?? '') == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                            <span
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="bx bx-chevron-down text-lg"></i>
                            </span>
                        </div>
                    </div>

                    {{-- 3. Filter Tipe Garasi --}}
                    <div>
                        <label for="tipe_garasi"
                            class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Tipe Garasi
                        </label>
                        <div class="relative">
                            <select id="tipe_garasi" name="tipe_garasi"
                                class="w-full appearance-none pl-4 pr-10 py-2 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition cursor-pointer">
                                <option value="">Semua Tipe</option>
                                @foreach ($daftarTipe as $tipe)
                                    <option value="{{ $tipe }}"
                                        {{ ($filters['tipe_garasi'] ?? '') == $tipe ? 'selected' : '' }}>
                                        {{ ucwords($tipe) }}
                                    </option>
                                @endforeach
                            </select>
                            <span
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="bx bx-chevron-down text-lg"></i>
                            </span>
                        </div>
                    </div>

                    {{-- 4. Filter Penyewa --}}
                    <div>
                        <label for="nik"
                            class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Penyewa
                        </label>
                        <div class="relative">
                            <select id="nik" name="nik"
                                class="w-full appearance-none pl-4 pr-10 py-2 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition cursor-pointer">
                                <option value="">Semua Penyewa</option>
                                @foreach ($daftarPenyewa as $p)
                                    <option value="{{ $p->nik }}"
                                        {{ ($filters['nik'] ?? '') == $p->nik ? 'selected' : '' }}>
                                        {{ $p->nama_lengkap }} ({{ $p->nik }})
                                    </option>
                                @endforeach
                            </select>
                            <span
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="bx bx-chevron-down text-lg"></i>
                            </span>
                        </div>
                    </div>

                    {{-- Tombol Saring & Atur Ulang --}}
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-4 rounded-full bg-pastel-blue hover:bg-[#b5d4ec] text-slate-800 font-bold text-sm shadow-xs transition-all duration-200 active:scale-95 cursor-pointer">
                            <i class="bx bx-search text-base"></i>
                        </button>
                        <a href="{{ route('admin.laporan.index') }}" title="Atur Ulang"
                            class="inline-flex items-center justify-center gap-1 py-2 px-3.5 rounded-full bg-pastel-pink/60 hover:bg-pastel-pink text-slate-800 font-bold text-sm transition-all duration-200 active:scale-95">
                            <i class="bx bx-refresh text-lg"></i>
                            <span class="sm:hidden xl:inline">Atur Ulang</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Ringkasan Total --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div
                class="bg-white/80 backdrop-blur-xl border border-white rounded-3xl shadow-soft p-5 flex items-center justify-between gap-4">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Transaksi</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-1 tracking-tight">
                        {{ $laporan['total_transaksi'] }}
                        <span class="text-sm font-semibold text-slate-500">Sewa</span>
                    </p>
                </div>
                <div
                    class="w-12 h-12 rounded-full bg-pastel-cream/85 flex items-center justify-center text-slate-800 shrink-0 shadow-xs">
                    <i class="bx bx-receipt text-2xl"></i>
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-xl border border-white rounded-3xl shadow-soft p-5 flex items-center justify-between gap-4">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Pendapatan</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-1 tracking-tight">
                        Rp {{ number_format($laporan['total_pendapatan'], 0, ',', '.') }}
                    </p>
                </div>
                <div
                    class="w-12 h-12 rounded-full bg-pastel-blue/75 flex items-center justify-center text-slate-800 shrink-0 shadow-xs">
                    <i class="bx bx-wallet text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Tabel Rekap Otomatis --}}
        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-3xl shadow-soft overflow-hidden">
            <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center gap-2.5">
                <div
                    class="w-8 h-8 rounded-full bg-pastel-pink/60 flex items-center justify-center text-slate-700 shrink-0">
                    <i class="bx bx-spreadsheet text-lg"></i>
                </div>
                <h2 class="text-base font-extrabold text-slate-800">{{ $laporan['judul_rekap'] }}</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr
                            class="border-b border-slate-100 bg-pastel-cream/30 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="py-3.5 px-5">Kategori / Periode</th>
                            <th class="py-3.5 px-5">Jumlah Sewa</th>
                            <th class="py-3.5 px-5">Total Biaya Sewa</th>
                            <th class="py-3.5 px-5">Total Biaya Listrik</th>
                            <th class="py-3.5 px-5 text-right">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/80">
                        @forelse($laporan['rekap'] as $r)
                            <tr class="hover:bg-pastel-blue/15 transition-colors duration-150">
                                <td class="py-3.5 px-5 font-bold text-slate-800">{{ $r['label'] }}</td>
                                <td class="py-3.5 px-5 font-semibold text-slate-700">
                                    {{ $r['jumlah_transaksi'] }} sewa
                                </td>
                                <td class="py-3.5 px-5 text-slate-600 whitespace-nowrap">
                                    Rp {{ number_format($r['total_biaya_sewa'], 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-5 text-slate-600 whitespace-nowrap">
                                    Rp {{ number_format($r['total_biaya_listrik'], 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-5 text-right font-bold text-slate-800 whitespace-nowrap">
                                    Rp {{ number_format($r['total_pendapatan'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 px-6 text-center">
                                    <div
                                        class="w-12 h-12 mx-auto mb-2.5 rounded-full bg-pastel-cream/70 flex items-center justify-center text-slate-500">
                                        <i class="bx bx-folder-open text-2xl"></i>
                                    </div>
                                    <p class="font-bold text-slate-700 text-sm">Tidak ada data rekap untuk pilihan ini</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Coba ubah atau atur ulang penyaringan di atas.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tabel Detail Transaksi --}}
        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-3xl shadow-soft overflow-hidden">
            <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between gap-2">
                <div class="flex items-center gap-2.5">
                    <div
                        class="w-8 h-8 rounded-full bg-pastel-blue/60 flex items-center justify-center text-slate-700 shrink-0">
                        <i class="bx bx-list-ul text-lg"></i>
                    </div>
                    <h2 class="text-base font-extrabold text-slate-800">Detail Transaksi Sewa</h2>
                </div>
                <span class="text-xs font-semibold text-slate-500">
                    {{ count($laporan['transaksi']) }} data ditampilkan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr
                            class="border-b border-slate-100 bg-pastel-cream/30 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="py-3.5 px-5">ID Sewa</th>
                            <th class="py-3.5 px-5">Penyewa</th>
                            <th class="py-3.5 px-5">Garasi</th>
                            <th class="py-3.5 px-5">Kendaraan</th>
                            <th class="py-3.5 px-5">Periode</th>
                            <th class="py-3.5 px-5 text-right">Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/80">
                        @forelse($laporan['transaksi'] as $s)
                            <tr class="hover:bg-pastel-blue/15 transition-colors duration-150">
                                {{-- ID Sewa --}}
                                <td class="py-3.5 px-5">
                                    <span class="font-mono text-xs font-bold text-slate-700">
                                        {{ $s->sewa_id }}
                                    </span>
                                </td>

                                {{-- Penyewa --}}
                                <td class="py-3.5 px-5">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-7 h-7 rounded-full bg-gradient-to-br from-pastel-pink/70 to-pastel-cream flex items-center justify-center text-[11px] font-extrabold text-slate-700 shrink-0">
                                            {{ strtoupper(substr($s->penyewa->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <span class="font-semibold text-slate-800">{{ $s->penyewa->nama_lengkap }}</span>
                                    </div>
                                </td>

                                {{-- Garasi --}}
                                <td class="py-3.5 px-5">
                                    <div class="font-bold text-slate-800 leading-tight">{{ $s->garasi_id }}</div>
                                    <div class="text-xs text-slate-500 capitalize mt-0.5">
                                        {{ $s->garasi->tipe_garasi }}
                                    </div>
                                </td>

                                {{-- Kendaraan --}}
                                <td class="py-3.5 px-5 text-slate-700 font-medium">
                                    {{ $s->kendaraan->merek_kendaraan }} {{ $s->kendaraan->model_merek }}
                                </td>

                                {{-- Periode --}}
                                <td class="py-3.5 px-5">
                                    <div
                                        class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-600 whitespace-nowrap">
                                        <i class="bx bx-calendar text-sm text-slate-400"></i>
                                        <span>{{ $s->tanggal_mulai->format('d-m-y') }}</span>
                                        <span class="text-slate-400">s/d</span>
                                        <span>{{ $s->tanggal_selesai->format('d-m-y') }}</span>
                                    </div>
                                </td>

                                {{-- Total Biaya --}}
                                <td class="py-3.5 px-5 text-right font-bold text-slate-800 whitespace-nowrap">
                                    Rp {{ number_format($s->total_biaya, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center">
                                    <div
                                        class="w-12 h-12 mx-auto mb-2.5 rounded-full bg-pastel-cream/70 flex items-center justify-center text-slate-500">
                                        <i class="bx bx-receipt text-2xl"></i>
                                    </div>
                                    <p class="font-bold text-slate-700 text-sm">Tidak ada transaksi ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        Belum ada transaksi yang sesuai dengan kriteria penyaringan.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
