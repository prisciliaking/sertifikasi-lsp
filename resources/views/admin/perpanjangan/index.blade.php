@extends('layouts.app')
@section('title', 'Perpanjangan Sewa Garasi')

@section('content')
    <div class="space-y-5">

        {{-- Header Halaman & Ringkasan --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-800">
                    Perpanjangan Sewa Garasi
                </h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Daftar unit garasi yang sedang aktif disewa dan dapat diperpanjang masa sewanya.
                </p>
            </div>

            {{-- Ringkasan Singkat --}}
            <div class="flex flex-wrap items-center gap-2">
                <div
                    class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/80 backdrop-blur-md border border-white shadow-soft text-xs font-semibold text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-pastel-blue"></span>
                    <span>Sewa Aktif:</span>
                    <strong class="text-slate-800">{{ $sewaAktif->count() }} Unit</strong>
                </div>
                <div
                    class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/80 backdrop-blur-md border border-white shadow-soft text-xs font-semibold text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-pastel-cream"></span>
                    <span>Total Nilai:</span>
                    <strong class="text-slate-800">
                        Rp {{ number_format($sewaAktif->sum('total_biaya'), 0, ',', '.') }}
                    </strong>
                </div>
            </div>
        </div>

        {{-- Kartu Tabel Sewa Aktif --}}
        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-3xl shadow-soft overflow-hidden">
            {{-- Garis Aksen Pastel --}}
            <div class="h-1.5 w-full bg-gradient-to-r from-pastel-blue via-pastel-cream to-pastel-pink"></div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr
                            class="border-b border-slate-100 bg-pastel-cream/30 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="py-3.5 px-5">ID Sewa</th>
                            <th class="py-3.5 px-5">Garasi</th>
                            <th class="py-3.5 px-5">Penyewa</th>
                            <th class="py-3.5 px-5">Periode Sewa</th>
                            <th class="py-3.5 px-5">Total Biaya</th>
                            <th class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/80">
                        @forelse($sewaAktif as $s)
                            <tr class="hover:bg-pastel-blue/15 transition-colors duration-150">
                                {{-- ID Sewa --}}
                                <td class="py-3.5 px-5">
                                    <span class="font-mono text-xs font-bold text-slate-700">
                                        {{ $s->sewa_id }}
                                    </span>
                                </td>

                                {{-- Garasi --}}
                                <td class="py-3.5 px-5">
                                    <div class="font-bold text-slate-800 leading-tight">{{ $s->garasi_id }}</div>
                                    <div class="text-xs text-slate-500 capitalize mt-0.5">
                                        {{ $s->garasi->tipe_garasi }}
                                    </div>
                                </td>

                                {{-- Penyewa --}}
                                <td class="py-3.5 px-5">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-7 h-7 rounded-full bg-gradient-to-br from-pastel-pink/70 to-pastel-cream flex items-center justify-center text-[11px] font-extrabold text-slate-700 shrink-0">
                                            {{ strtoupper(substr($s->penyewa->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <span class="font-semibold text-slate-700">{{ $s->penyewa->nama_lengkap }}</span>
                                    </div>
                                </td>

                                {{-- Periode Sewa --}}
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
                                <td class="py-3.5 px-5">
                                    <span class="font-bold text-slate-800 whitespace-nowrap">
                                        Rp {{ number_format($s->total_biaya, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="py-3.5 px-5 text-right">
                                    <a href="{{ route('admin.perpanjangan.edit', $s->sewa_id) }}"
                                        class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-pastel-blue/85 hover:bg-pastel-blue text-slate-800 text-xs font-bold shadow-xs transition-all duration-200 active:scale-95">
                                        <i class="bx bx-calendar-plus text-base"></i>
                                        <span>Perpanjang</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center">
                                    <div
                                        class="w-12 h-12 mx-auto mb-2.5 rounded-full bg-pastel-cream/70 flex items-center justify-center text-slate-500">
                                        <i class="bx bx-calendar-x text-2xl"></i>
                                    </div>
                                    <p class="font-bold text-slate-700 text-sm">Tidak ada garasi yang sedang disewa</p>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        Transaksi sewa yang sedang aktif akan tampil di sini.
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
