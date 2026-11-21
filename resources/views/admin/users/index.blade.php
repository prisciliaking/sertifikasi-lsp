@extends('layouts.app')
@section('title', 'Validasi Penyewa')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Daftar Validasi Pendaftar (Penyewa)</h1>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="p-3">NIK</th>
                        <th class="p-3">Nama Lengkap</th>
                        <th class="p-3">No. HP</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penyewaList as $p)
                        <tr class="border-b">
                            <td class="p-3">{{ $p->nik }}</td>
                            <td class="p-3">{{ $p->nama_lengkap }}</td>
                            <td class="p-3">{{ $p->no_hp }}</td>
                            <td class="p-3">{{ $p->email }}</td>
                            <td class="p-3 font-semibold uppercase">{{ $p->status_validasi }}</td>
                            <td class="p-3 flex gap-2">
                                @if ($p->status_validasi !== 'diterima')
                                    <form action="{{ route('admin.users.update-status', $p->nik) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status_validasi" value="diterima">
                                        <button
                                            class="px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">Terima</button>
                                    </form>
                                @endif

                                @if ($p->status_validasi !== 'ditolak')
                                    <form action="{{ route('admin.users.update-status', $p->nik) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status_validasi" value="ditolak">
                                        <button
                                            class="px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">Tolak</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">Belum ada pendaftar penyewa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
