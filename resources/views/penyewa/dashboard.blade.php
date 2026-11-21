@extends('layouts.app')
@section('title', 'Dashboard Penyewa')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Daftar Sewa Garasi Saya</h1>
            <a href="{{ route('penyewa.sewa.create') }}"
                class="bg-teal-700 text-white px-4 py-2 rounded text-sm hover:bg-teal-800">
                + Sewa Garasi Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="p-3">ID Sewa</th>
                        <th class="p-3">Garasi</th>
                        <th class="p-3">Kendaraan</th>
                        <th class="p-3">Tipe</th>
                        <th class="p-3">Periode</th>
                        <th class="p-3">Total Biaya</th>
                        <th class="p-3">Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sewaList as $s)
                        <tr class="border-b">
                            <td class="p-3 font-semibold">{{ $s->sewa_id }}</td>
                            <td class="p-3">{{ $s->garasi_id }} ({{ $s->garasi->tipe_garasi }})</td>
                            <td class="p-3">
                                {{ $s->kendaraan->merek_kendaraan }} {{ $s->kendaraan->model_merek }}
                                <span
                                    class="text-xs text-gray-500 block">{{ $s->kendaraan->plat_nomor ?? 'Tanpa Plat' }}</span>
                            </td>
                            <td class="p-3 capitalize">{{ $s->tipe_sewa }}</td>
                            <td class="p-3">{{ $s->tanggal_mulai->format('d-m-y') }} s/d
                                {{ $s->tanggal_selesai->format('d-m-y') }}</td>
                            <td class="p-3 font-semibold">Rp {{ number_format($s->total_biaya, 0, ',', '.') }}</td>
                            <td class="p-3">
                                <a href="{{ asset($s->bukti_bayar) }}" target="_blank"
                                    class="text-teal-700 underline text-xs">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">Anda belum memiliki riwayat sewa
                                garasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
