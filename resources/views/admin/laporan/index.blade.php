@extends('layouts.app')
@section('title', 'Laporan Sewa Garasi')

@section('content')
    <div class="space-y-6">
        <!-- Filter 4 Kategori -->
        <div class="bg-white p-6 rounded shadow">
            <h1 class="text-xl font-bold mb-4">Laporan Sewa Garasi</h1>

            <form method="GET" action="{{ route('admin.laporan.index') }}"
                class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <!-- 1. Filter Tahun (Per Bulan dalam Tahun Tertentu) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tahun</label>
                    <select name="tahun" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">Semua Tahun</option>
                        @foreach ($daftarTahun as $thn)
                            <option value="{{ $thn }}" {{ ($filters['tahun'] ?? '') == $thn ? 'selected' : '' }}>
                                {{ $thn }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 2. Filter Bulan (Per Hari dalam Bulan Tertentu) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Bulan</label>
                    <select name="bulan" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">Semua Bulan</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ ($filters['bulan'] ?? '') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- 3. Filter Tipe Garasi -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tipe Garasi</label>
                    <select name="tipe_garasi" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">Semua Tipe</option>
                        @foreach ($daftarTipe as $tipe)
                            <option value="{{ $tipe }}"
                                {{ ($filters['tipe_garasi'] ?? '') == $tipe ? 'selected' : '' }}>
                                {{ ucwords($tipe) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 4. Filter Penyewa -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Penyewa</label>
                    <select name="nik" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">Semua Penyewa</option>
                        @foreach ($daftarPenyewa as $p)
                            <option value="{{ $p->nik }}"
                                {{ ($filters['nik'] ?? '') == $p->nik ? 'selected' : '' }}>
                                {{ $p->nama_lengkap }} ({{ $p->nik }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="flex-1 bg-teal-700 text-white py-2 px-3 rounded text-sm hover:bg-teal-800">
                        Filter
                    </button>
                    <a href="{{ route('admin.laporan.index') }}"
                        class="py-2 px-3 border rounded text-sm hover:bg-gray-100">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Ringkasan Total -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white p-5 rounded shadow border-l-4 border-teal-700">
                <div class="text-xs text-gray-500 uppercase font-semibold">Total Transaksi</div>
                <div class="text-2xl font-bold mt-1">{{ $laporan['total_transaksi'] }} Sewa</div>
            </div>
            <div class="bg-white p-5 rounded shadow border-l-4 border-teal-700">
                <div class="text-xs text-gray-500 uppercase font-semibold">Total Pendapatan</div>
                <div class="text-2xl font-bold text-teal-800 mt-1">
                    Rp {{ number_format($laporan['total_pendapatan'], 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- Tabel Rekap Otomatis (Per Bulan / Per Hari / Per Tipe) -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-bold mb-3">{{ $laporan['judul_rekap'] }}</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Kategori / Periode</th>
                            <th class="p-3">Jumlah Sewa</th>
                            <th class="p-3">Total Biaya Sewa</th>
                            <th class="p-3">Total Biaya Listrik</th>
                            <th class="p-3">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan['rekap'] as $r)
                            <tr class="border-b">
                                <td class="p-3 font-semibold">{{ $r['label'] }}</td>
                                <td class="p-3">{{ $r['jumlah_transaksi'] }}</td>
                                <td class="p-3">Rp {{ number_format($r['total_biaya_sewa'], 0, ',', '.') }}</td>
                                <td class="p-3">Rp {{ number_format($r['total_biaya_listrik'], 0, ',', '.') }}</td>
                                <td class="p-3 font-bold text-teal-800">Rp
                                    {{ number_format($r['total_pendapatan'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">Tidak ada data untuk filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Detail Transaksi -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-bold mb-3">Detail Transaksi Sewa</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">ID Sewa</th>
                            <th class="p-3">Penyewa</th>
                            <th class="p-3">Garasi</th>
                            <th class="p-3">Kendaraan</th>
                            <th class="p-3">Periode</th>
                            <th class="p-3">Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan['transaksi'] as $s)
                            <tr class="border-b">
                                <td class="p-3 font-semibold">{{ $s->sewa_id }}</td>
                                <td class="p-3">{{ $s->penyewa->nama_lengkap }}</td>
                                <td class="p-3">{{ $s->garasi_id }} ({{ ucwords($s->garasi->tipe_garasi) }})</td>
                                <td class="p-3">{{ $s->kendaraan->merek_kendaraan }} {{ $s->kendaraan->model_merek }}
                                </td>
                                <td class="p-3">{{ $s->tanggal_mulai->format('d-m-y') }} s/d
                                    {{ $s->tanggal_selesai->format('d-m-y') }}</td>
                                <td class="p-3 font-semibold">Rp {{ number_format($s->total_biaya, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">Tidak ada transaksi ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
