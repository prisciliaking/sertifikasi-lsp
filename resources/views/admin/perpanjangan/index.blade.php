@extends('layouts.app')
@section('title', 'Perpanjangan Sewa Garasi')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Daftar Garasi Sedang Disewa (Aktif)</h1>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="p-3">ID Sewa</th>
                        <th class="p-3">Garasi</th>
                        <th class="p-3">Penyewa</th>
                        <th class="p-3">Periode Sewa</th>
                        <th class="p-3">Total Biaya</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sewaAktif as $s)
                        <tr class="border-b">
                            <td class="p-3 font-semibold">{{ $s->sewa_id }}</td>
                            <td class="p-3">{{ $s->garasi_id }} ({{ $s->garasi->tipe_garasi }})</td>
                            <td class="p-3">{{ $s->penyewa->nama_lengkap }}</td>
                            <td class="p-3">{{ $s->tanggal_mulai->format('d-m-y') }} s/d
                                {{ $s->tanggal_selesai->format('d-m-y') }}</td>
                            <td class="p-3">Rp {{ number_format($s->total_biaya, 0, ',', '.') }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.perpanjangan.edit', $s->sewa_id) }}"
                                    class="px-3 py-1 bg-teal-700 text-white rounded text-xs hover:bg-teal-800">
                                    Perpanjang
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">Tidak ada garasi yang sedang disewa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
