@extends('layouts.app')
@section('title', 'Sewa Garasi Baru')

@section('content')
    <div class="max-w-3xl mx-auto space-y-5">

        {{-- Header Halaman --}}
        <div>
            <a href="{{ route('penyewa.dashboard') }}"
                class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 hover:text-slate-800 mb-2 transition">
                <i class="bx bx-arrow-left-stroke text-lg"></i>
                <span>Kembali ke Beranda</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-800">
                Sewa Garasi Baru
            </h1>
            <p class="text-sm text-slate-500 mt-0.5">
                Lengkapi data kendaraan dan jadwal sewa untuk memilih unit garasi yang tersedia.
            </p>
        </div>

        {{-- Kartu Formulir --}}
        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-3xl shadow-soft overflow-hidden">
            {{-- Garis Aksen Pastel --}}
            <div class="h-1.5 w-full bg-gradient-to-r from-pastel-cream via-pastel-pink to-pastel-blue"></div>

            <form action="{{ route('penyewa.sewa.store') }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-7">
                @csrf

                <div class="space-y-7">
                    {{-- 1. Detail Kendaraan --}}
                    <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                        <div
                            class="w-7 h-7 rounded-full bg-pastel-cream flex items-center justify-center text-xs font-extrabold text-slate-800 shrink-0">
                            1
                        </div>
                        <h2 class="text-sm font-extrabold text-slate-800">Detail Kendaraan</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Tipe Kendaraan --}}
                        <div>
                            <label for="tipe_kendaraan"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Tipe Kendaraan
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-car text-lg"></i>
                                </span>
                                <select name="tipe_kendaraan" id="tipe_kendaraan" required
                                    class="w-full appearance-none pl-10 pr-10 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition cursor-pointer">
                                    <option value="sepeda">Sepeda</option>
                                    <option value="sepeda motor">Sepeda Motor</option>
                                    <option value="mobil">Mobil</option>
                                    <option value="mobil listrik">Mobil Listrik</option>
                                </select>
                                <span
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-chevron-down text-lg"></i>
                                </span>
                            </div>
                        </div>

                        {{-- Nomor Plat --}}
                        <div id="plat_wrapper" class="hidden">
                            <label for="plat_nomor"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Nomor Plat
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-id-card text-lg"></i>
                                </span>
                                <input type="text" name="plat_nomor" id="plat_nomor" value="{{ old('plat_nomor') }}"
                                    placeholder="Contoh: L 1234 AB"
                                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition">
                            </div>
                        </div>

                        {{-- Merek --}}
                        <div>
                            <label for="merek_kendaraan"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Merek
                            </label>
                            <input id="merek_kendaraan" type="text" name="merek_kendaraan"
                                value="{{ old('merek_kendaraan') }}" required placeholder="Contoh: Toyota, Honda"
                                class="w-full px-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition">
                        </div>

                        {{-- Tipe / Model --}}
                        <div>
                            <label for="model_merek"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Tipe / Model
                            </label>
                            <input id="model_merek" type="text" name="model_merek" value="{{ old('model_merek') }}"
                                required placeholder="Contoh: Rush, Beat, Ioniq 5"
                                class="w-full px-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition">
                        </div>

                        {{-- Kapasitas Baterai (Khusus Mobil Listrik) --}}
                        <div id="kapasitas_wrapper" class="hidden md:col-span-2">
                            <label for="kapasitas_baterai"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Kapasitas Baterai (kWh)
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-bolt text-lg"></i>
                                </span>
                                <input type="number" step="0.1" name="kapasitas_baterai" id="kapasitas_baterai"
                                    value="{{ old('kapasitas_baterai') }}" placeholder="Contoh: 58.0"
                                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-semibold placeholder:font-normal placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-cream/70 focus:border-pastel-cream transition">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Detail Sewa & Garasi --}}
                <div class="space-y-4 mt-4">
                    <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                        <div
                            class="w-7 h-7 rounded-full bg-pastel-blue/75 flex items-center justify-center text-xs font-extrabold text-slate-800 shrink-0">
                            2
                        </div>
                        <h2 class="text-sm font-extrabold text-slate-800">Detail Sewa &amp; Garasi</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Tipe Sewa --}}
                        <div>
                            <label for="tipe_sewa"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Tipe Sewa
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-clock-3 text-lg"></i>
                                </span>
                                <select name="tipe_sewa" id="tipe_sewa" required
                                    class="w-full appearance-none pl-10 pr-10 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition cursor-pointer">
                                    <option value="harian">Harian</option>
                                    <option value="bulanan">Bulanan (1 Bulan)</option>
                                </select>
                                <span
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-chevron-down text-lg"></i>
                                </span>
                            </div>
                        </div>

                        {{-- Jumlah Hari --}}
                        <div id="hari_wrapper">
                            <label for="jumlah_hari"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Jumlah Hari
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-calendar-plus text-lg"></i>
                                </span>
                                <input type="number" name="jumlah_hari" id="jumlah_hari"
                                    value="{{ old('jumlah_hari', 1) }}" min="1"
                                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-semibold focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition">
                            </div>
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label for="tanggal_mulai"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Tanggal Mulai
                            </label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                value="{{ old('tanggal_mulai', today()->toDateString()) }}"
                                min="{{ today()->toDateString() }}" required
                                class="w-full px-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition">
                        </div>

                        {{-- Tanggal Selesai (Otomatis) --}}
                        <div>
                            <label for="tanggal_selesai_ui"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Tanggal Selesai (Otomatis)
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-calendar-check text-lg"></i>
                                </span>
                                <input type="text" id="tanggal_selesai_ui" readonly
                                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200/70 rounded-full text-slate-600 font-semibold cursor-not-allowed">
                            </div>
                        </div>

                        {{-- Tipe Garasi --}}
                        <div>
                            <label for="tipe_garasi"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Tipe Garasi
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-home-alt text-lg"></i>
                                </span>
                                <select name="tipe_garasi" id="tipe_garasi" required
                                    class="w-full appearance-none pl-10 pr-10 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition cursor-pointer"></select>
                                <span
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-chevron-down text-lg"></i>
                                </span>
                            </div>
                        </div>

                        {{-- Pilih Garasi Tersedia --}}
                        <div>
                            <label for="garasi_id"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Pilih Garasi Tersedia
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-key text-lg"></i>
                                </span>
                                <select name="garasi_id" id="garasi_id" required
                                    class="w-full appearance-none pl-10 pr-10 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition cursor-pointer"></select>
                                <span
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-chevron-down text-lg"></i>
                                </span>
                            </div>
                        </div>

                        {{-- Sisa Baterai Awal (Khusus Mobil Listrik + Garasi Listrik) --}}
                        <div id="sisa_baterai_wrapper" class="hidden md:col-span-2">
                            <label for="sisa_baterai_awal"
                                class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Sisa Baterai Saat Ini (0 - 100%)
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-battery-charging text-lg"></i>
                                </span>
                                <input type="number" step="0.1" min="0" max="100"
                                    name="sisa_baterai_awal" id="sisa_baterai_awal"
                                    value="{{ old('sisa_baterai_awal') }}" placeholder="Contoh: 40"
                                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-full text-slate-800 font-semibold placeholder:font-normal placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-cream/70 focus:border-pastel-cream transition">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. Estimasi Biaya & Bukti Pelunasan --}}
                <div class="space-y-4 mt-4">
                    <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                        <div
                            class="w-7 h-7 rounded-full bg-pastel-pink/70 flex items-center justify-center text-xs font-extrabold text-slate-800 shrink-0">
                            3
                        </div>
                        <h2 class="text-sm font-extrabold text-slate-800">Ringkasan Biaya &amp; Pembayaran</h2>
                    </div>

                    {{-- Box Estimasi Biaya --}}
                    <div
                        class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-pastel-blue/35 via-pastel-cream/30 to-pastel-pink/25 border border-white space-y-2 text-sm">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Biaya Sewa</span>
                            <strong id="est_sewa" class="text-slate-800">Rp 0</strong>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Biaya Isi Daya Listrik</span>
                            <strong id="est_listrik" class="text-slate-800">Rp 0</strong>
                        </div>
                        <div class="flex items-center justify-between pt-2.5 mt-1 border-t border-white/80">
                            <span class="font-bold text-slate-800">Total Biaya</span>
                            <strong id="est_total" class="text-xl font-extrabold text-slate-900 tracking-tight">Rp
                                0</strong>
                        </div>
                        <div id="ajax_error"
                            class="hidden mt-2 px-3 py-2 rounded-xl bg-pastel-pink/70 text-slate-800 text-xs font-bold">
                        </div>
                    </div>

                    {{-- Unggah Bukti Pelunasan --}}
                    <div>
                        <label for="bukti_bayar"
                            class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Unggah Bukti Pelunasan (JPG/PNG)
                        </label>
                        <input id="bukti_bayar" type="file" name="bukti_bayar" accept="image/*" required
                            class="w-full text-xs text-slate-600 bg-white/90 border border-dashed border-slate-300 rounded-2xl p-2.5
                            file:mr-3 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold
                            file:bg-pastel-cream file:text-slate-800 hover:file:bg-[#f6e1aa] file:cursor-pointer
                            focus:outline-none focus:ring-4 focus:ring-pastel-cream/60 transition cursor-pointer">
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-wrap items-center gap-2.5 pt-2">
                    <button type="submit"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-pastel-blue hover:bg-[#b5d4ec] text-slate-800 font-bold text-sm shadow-sm hover:shadow transition-all duration-200 active:scale-95 cursor-pointer">
                        <span>Simpan</span>
                    </button>
                    <a href="{{ route('penyewa.dashboard') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-full bg-white hover:bg-slate-50 border border-slate-200/80 text-slate-600 font-semibold text-sm transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
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

            // Perbarui pilihan tipe garasi sesuai kendaraan
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
