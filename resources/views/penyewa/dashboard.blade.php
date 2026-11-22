@extends('layouts.app')
@section('title', 'Beranda Penyewa')

@section('content')
    <div class="space-y-5">

        {{-- Header Halaman & Tombol Sewa Baru --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-800">
                    Daftar Sewa Garasi Saya
                </h1>
                <p class="text-sm text-slate-500 mt-0.5">
                    Pantau riwayat penyewaan garasi, periode aktif, dan bukti pembayaran Anda.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <div
                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-white/80 backdrop-blur-md border border-white shadow-soft text-xs font-semibold text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-pastel-cream"></span>
                    <span>Total Riwayat:</span>
                    <strong class="text-slate-800">{{ $sewaList->count() }} Sewa</strong>
                </div>

                <a href="{{ route('penyewa.sewa.create') }}"
                    class="inline-flex items-center gap-1.5 px-5 py-2 rounded-full bg-pastel-blue hover:bg-[#b5d4ec] text-slate-800 text-xs font-bold shadow-sm hover:shadow transition-all duration-200 active:scale-95">
                    <i class="bx bx-plus text-base"></i>
                    <span>Sewa Garasi Baru</span>
                </a>
            </div>
        </div>

        {{-- Kartu Tabel Riwayat Sewa --}}
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
                            <th class="py-3.5 px-5">Kendaraan</th>
                            <th class="py-3.5 px-5">Tipe</th>
                            <th class="py-3.5 px-5">Periode</th>
                            <th class="py-3.5 px-5">Total Biaya</th>
                            <th class="py-3.5 px-5 text-right">Bukti</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/80">
                        @forelse($sewaList as $s)
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

                                {{-- Kendaraan --}}
                                <td class="py-3.5 px-5">
                                    <div class="font-semibold text-slate-800 leading-tight">
                                        {{ $s->kendaraan->merek_kendaraan }} {{ $s->kendaraan->model_merek }}
                                    </div>
                                    <div class="text-xs text-slate-500 font-mono mt-0.5">
                                        {{ $s->kendaraan->plat_nomor ?? 'Tanpa Plat' }}
                                    </div>
                                </td>

                                {{-- Tipe Sewa --}}
                                <td class="py-3.5 px-5 capitalize text-xs font-semibold text-slate-600">
                                    {{ $s->tipe_sewa }}
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
                                <td class="py-3.5 px-5">
                                    <span class="font-bold text-slate-800 whitespace-nowrap">
                                        Rp {{ number_format($s->total_biaya, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Bukti Pembayaran --}}
                                <td class="py-3.5 px-5 text-right">
                                    <a href="{{ asset($s->bukti_bayar) }}" target="_blank"
                                        class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full bg-pastel-cream/80 hover:bg-pastel-cream text-slate-800 text-xs font-bold shadow-xs transition-all duration-200 active:scale-95">
                                        <i class="bx bx-receipt text-sm"></i>
                                        <span>Lihat</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 px-6 text-center">
                                    <div
                                        class="w-12 h-12 mx-auto mb-2.5 rounded-full bg-pastel-cream/70 flex items-center justify-center text-slate-500">
                                        <i class="bx bx-car text-2xl"></i>
                                    </div>
                                    <p class="font-bold text-slate-700 text-sm">Anda belum memiliki riwayat sewa garasi</p>
                                    <p class="text-xs text-slate-400 mt-0.5 mb-4">
                                        Mulai sewa unit garasi pertama Anda dengan menekan tombol di bawah.
                                    </p>
                                    <a href="{{ route('penyewa.sewa.create') }}"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-pastel-blue hover:bg-[#b5d4ec] text-slate-800 text-xs font-bold shadow-xs transition">
                                        <i class="bx bx-plus text-base"></i>
                                        <span>Sewa Garasi Baru</span>
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
