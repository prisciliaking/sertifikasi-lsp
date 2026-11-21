@extends('layouts.app')
@section('title', 'Sewa Garasi Baru')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Form Sewa Garasi Baru</h1>

        <form action="{{ route('penyewa.sewa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- 1. Detail Kendaraan -->
            <h2 class="font-semibold text-teal-700 border-b pb-1">1. Detail Kendaraan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tipe Kendaraan</label>
                    <select name="tipe_kendaraan" id="tipe_kendaraan" required class="w-full border rounded px-3 py-2">
                        <option value="sepeda">Sepeda</option>
                        <option value="sepeda motor">Sepeda Motor</option>
                        <option value="mobil">Mobil</option>
                        <option value="mobil listrik">Mobil Listrik</option>
                    </select>
                </div>
                <div id="plat_wrapper" class="hidden">
                    <label class="block text-sm font-medium mb-1">Nomor Plat</label>
                    <input type="text" name="plat_nomor" id="plat_nomor" value="{{ old('plat_nomor') }}"
                        class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Merek</label>
                    <input type="text" name="merek_kendaraan" value="{{ old('merek_kendaraan') }}" required
                        class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tipe / Model</label>
                    <input type="text" name="model_merek" value="{{ old('model_merek') }}" required
                        class="w-full border rounded px-3 py-2">
                </div>
                <div id="kapasitas_wrapper" class="hidden">
                    <label class="block text-sm font-medium mb-1">Kapasitas Baterai (kWh)</label>
                    <input type="number" step="0.1" name="kapasitas_baterai" id="kapasitas_baterai"
                        value="{{ old('kapasitas_baterai') }}" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <!-- 2. Detail Sewa & Garasi -->
            <h2 class="font-semibold text-teal-700 border-b pb-1 pt-2">2. Detail Sewa & Garasi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tipe Sewa</label>
                    <select name="tipe_sewa" id="tipe_sewa" required class="w-full border rounded px-3 py-2">
                        <option value="harian">Harian</option>
                        <option value="bulanan">Bulanan (1 Bulan)</option>
                    </select>
                </div>
                <div id="hari_wrapper">
                    <label class="block text-sm font-medium mb-1">Jumlah Hari</label>
                    <input type="number" name="jumlah_hari" id="jumlah_hari" value="{{ old('jumlah_hari', 1) }}"
                        min="1" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                        value="{{ old('tanggal_mulai', today()->toDateString()) }}" min="{{ today()->toDateString() }}"
                        required class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal Selesai (Otomatis)</label>
                    <input type="text" id="tanggal_selesai_ui" readonly
                        class="w-full border rounded px-3 py-2 bg-gray-100">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tipe Garasi</label>
                    <select name="tipe_garasi" id="tipe_garasi" required class="w-full border rounded px-3 py-2"></select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Pilih Garasi Tersedia</label>
                    <select name="garasi_id" id="garasi_id" required class="w-full border rounded px-3 py-2"></select>
                </div>
                <div id="sisa_baterai_wrapper" class="hidden md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Sisa Baterai Saat Ini (0 - 100%)</label>
                    <input type="number" step="0.1" min="0" max="100" name="sisa_baterai_awal"
                        id="sisa_baterai_awal" value="{{ old('sisa_baterai_awal') }}"
                        class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <!-- 3. Estimasi Biaya & Bukti Bayar -->
            <div class="p-4 bg-teal-50 border border-teal-200 rounded text-sm space-y-1">
                <div>Biaya Sewa: <strong id="est_sewa">Rp 0</strong></div>
                <div>Biaya Isi Listrik: <strong id="est_listrik">Rp 0</strong></div>
                <div class="text-base">Total Biaya: <strong id="est_total" class="text-teal-800">Rp 0</strong></div>
                <div id="ajax_error" class="text-red-600 font-medium hidden"></div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Upload Bukti Pelunasan (JPG/PNG)</label>
                <input type="file" name="bukti_bayar" accept="image/*" required
                    class="w-full border rounded px-3 py-2">
            </div>

            <button type="submit" class="w-full bg-teal-700 text-white py-2 rounded hover:bg-teal-800 font-semibold">
                Simpan & Bayar Sewa
            </button>
        </form>
    </div>

    <script>
        const el = (id) => document.getElementById(id);
        let availableGarasi = [];

        const allowedMap = {
            'sepeda': ['sepeda'],
            'sepeda motor': ['sepeda'],
            'mobil': ['mobil'],
            'mobil listrik': ['mobil', 'mobil listrik']
        };

        function updateVehicleFields() {
            const tipe = el('tipe_kendaraan').value;
            el('plat_wrapper').classList.toggle('hidden', tipe === 'sepeda');
            el('plat_nomor').required = tipe !== 'sepeda';

            const isEV = tipe === 'mobil listrik';
            el('kapasitas_wrapper').classList.toggle('hidden', !isEV);
            el('kapasitas_baterai').required = isEV;

            // Update pilihan tipe garasi sesuai kendaraan
            const garasiSelect = el('tipe_garasi');
            garasiSelect.innerHTML = allowedMap[tipe]
                .map(t => `<option value="${t}">${t.toUpperCase()}</option>`).join('');

            toggleBatteryField();
            fetchAvailability();
        }

        function toggleBatteryField() {
            const show = el('tipe_kendaraan').value === 'mobil listrik' && el('tipe_garasi').value === 'mobil listrik';
            el('sisa_baterai_wrapper').classList.toggle('hidden', !show);
            el('sisa_baterai_awal').required = show;
            calculateEstimate();
        }

        function toggleHariField() {
            const isHarian = el('tipe_sewa').value === 'harian';
            el('hari_wrapper').classList.toggle('hidden', !isHarian);
            el('jumlah_hari').required = isHarian;
            fetchAvailability();
        }

        async function fetchAvailability() {
            const params = new URLSearchParams({
                tanggal_mulai: el('tanggal_mulai').value,
                tipe_sewa: el('tipe_sewa').value,
                jumlah_hari: el('jumlah_hari').value,
                tipe_garasi: el('tipe_garasi').value
            });

            const res = await fetch(`{{ route('penyewa.sewa.check') }}?${params}`);
            const data = await res.json();

            if (!res.ok) {
                el('ajax_error').textContent = data.error;
                el('ajax_error').classList.remove('hidden');
                el('garasi_id').innerHTML = '';
                return;
            }

            el('ajax_error').classList.add('hidden');
            el('tanggal_selesai_ui').value = data.tanggal_selesai_ui;
            el('jumlah_hari').max = data.maks_hari;
            availableGarasi = data.garasi;

            el('garasi_id').innerHTML = availableGarasi.length ?
                availableGarasi.map(g =>
                    `<option value="${g.garasi_id}">${g.garasi_id} - Rp ${Number(g.harga_sewa).toLocaleString('id-ID')}/hari</option>`
                    ).join('') :
                '<option value="">Tidak ada garasi tersedia</option>';

            calculateEstimate();
        }

        function calculateEstimate() {
            const g = availableGarasi.find(item => item.garasi_id === el('garasi_id').value);
            if (!g) {
                el('est_sewa').textContent = 'Rp 0';
                el('est_listrik').textContent = 'Rp 0';
                el('est_total').textContent = 'Rp 0';
                return;
            }

            const hargaHarian = Number(g.harga_sewa);
            const biayaSewa = el('tipe_sewa').value === 'bulanan' ?
                25 * hargaHarian :
                Number(el('jumlah_hari').value || 0) * hargaHarian;

            let biayaListrik = 0;
            if (el('tipe_kendaraan').value === 'mobil listrik' && g.tipe_garasi === 'mobil listrik') {
                const kap = Number(el('kapasitas_baterai').value || 0);
                const sisa = Number(el('sisa_baterai_awal').value || 0);
                biayaListrik = (kap * ((100 - sisa) / 100)) * Number(g.harga_per_kwh || 0);
            }

            const fmt = (n) => 'Rp ' + Math.round(n).toLocaleString('id-ID');
            el('est_sewa').textContent = fmt(biayaSewa);
            el('est_listrik').textContent = fmt(biayaListrik);
            el('est_total').textContent = fmt(biayaSewa + biayaListrik);
        }

        el('tipe_kendaraan').addEventListener('change', updateVehicleFields);
        el('tipe_garasi').addEventListener('change', () => {
            toggleBatteryField();
            fetchAvailability();
        });
        el('tipe_sewa').addEventListener('change', toggleHariField);
        ['tanggal_mulai', 'jumlah_hari'].forEach(id => el(id).addEventListener('change', fetchAvailability));
        ['garasi_id', 'kapasitas_baterai', 'sisa_baterai_awal'].forEach(id => el(id).addEventListener('input',
            calculateEstimate));

        updateVehicleFields();
    </script>
@endsection
