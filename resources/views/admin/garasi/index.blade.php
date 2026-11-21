@extends('layouts.app')
@section('title', 'Kelola Garasi')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Form Tambah Garasi Batch -->
        <div class="bg-white p-6 rounded shadow h-fit">
            <h2 class="text-lg font-bold mb-4">Buat Garasi Baru (Batch)</h2>
            <form action="{{ route('admin.garasi.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Tipe Garasi</label>
                    <select name="tipe_garasi" id="tipe_garasi" required class="w-full border rounded px-3 py-2">
                        <option value="sepeda" {{ old('tipe_garasi') == 'sepeda' ? 'selected' : '' }}>Sepeda / Motor (S)
                        </option>
                        <option value="mobil" {{ old('tipe_garasi') == 'mobil' ? 'selected' : '' }}>Mobil (C)</option>
                        <option value="mobil listrik" {{ old('tipe_garasi') == 'mobil listrik' ? 'selected' : '' }}>Mobil
                            Listrik (E)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Jumlah Garasi (Max 999)</label>
                    <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" max="999"
                        required class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Harga Sewa Harian (Rp)</label>
                    <input type="number" name="harga_sewa" value="{{ old('harga_sewa') }}" min="0" required
                        class="w-full border rounded px-3 py-2">
                </div>

                <div id="kwh_wrapper" class="hidden">
                    <label class="block text-sm font-medium mb-1">Harga Isi Listrik per kWh (Rp)</label>
                    <input type="number" name="harga_per_kwh" id="harga_per_kwh" value="{{ old('harga_per_kwh') }}"
                        min="0" class="w-full border rounded px-3 py-2">
                </div>

                <button type="submit" class="w-full bg-teal-700 text-white py-2 rounded hover:bg-teal-800">
                    Generate Garasi
                </button>
            </form>
        </div>

        <!-- Daftar Garasi -->
        <div class="md:col-span-2 bg-white p-6 rounded shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">Daftar Garasi</h2>
                <form method="GET" action="{{ route('admin.garasi.index') }}" class="flex gap-2">
                    <select name="tipe" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                        <option value="">Semua Tipe</option>
                        <option value="sepeda" {{ $filterTipe == 'sepeda' ? 'selected' : '' }}>Sepeda (S)</option>
                        <option value="mobil" {{ $filterTipe == 'mobil' ? 'selected' : '' }}>Mobil (C)</option>
                        <option value="mobil listrik" {{ $filterTipe == 'mobil listrik' ? 'selected' : '' }}>Mobil Listrik
                            (E)</option>
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">ID</th>
                            <th class="p-3">Tipe</th>
                            <th class="p-3">Harga Harian</th>
                            <th class="p-3">Harga / kWh</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($garasiList as $g)
                            <tr class="border-b">
                                <td class="p-3 font-bold">{{ $g->garasi_id }}</td>
                                <td class="p-3 capitalize">{{ $g->tipe_garasi }}</td>
                                <td class="p-3">Rp {{ number_format($g->harga_sewa, 0, ',', '.') }}</td>
                                <td class="p-3">
                                    {{ $g->harga_per_kwh ? 'Rp ' . number_format($g->harga_per_kwh, 0, ',', '.') : '-' }}
                                </td>
                                <td class="p-3">
                                    <span
                                        class="px-2 py-1 rounded text-xs font-semibold {{ $g->status_sewa ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $g->status_sewa ? 'Used' : 'Available' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">Belum ada data garasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $garasiList->links() }}
            </div>
        </div>
    </div>

    <script>
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
    </script>
@endsection
