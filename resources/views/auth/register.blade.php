@extends('layouts.app')
@section('title', 'Daftar Penyewa')

@section('content')
    <div class="min-h-[80vh] flex items-center justify-center py-6">
        <div
            class="w-full max-w-lg bg-white/80 backdrop-blur-xl border border-white rounded-3xl shadow-soft overflow-hidden">

            {{-- Top Pastel Accent Bar --}}
            <div class="h-2 w-full bg-gradient-to-r from-pastel-pink via-pastel-cream to-pastel-blue"></div>

            <div class="p-8 sm:p-9">
                {{-- Header --}}
                <div class="text-center mb-7">
                    <div
                        class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-pastel-pink/80 via-pastel-cream/80 to-pastel-blue/80 p-[1.5px] shadow-sm">
                        <div
                            class="w-full h-full bg-white/90 rounded-[14px] flex items-center justify-center text-slate-800">
                            <i class="bx bx-user-plus text-3xl"></i>
                        </div>
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Registrasi Penyewa</h1>
                    <p class="text-sm text-slate-500 mt-1">Lengkapi data diri untuk mulai menyewa garasi</p>
                </div>

                {{-- Register Form --}}
                <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="nama_lengkap"
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="bx bx-user text-lg"></i>
                            </span>
                            <input id="nama_lengkap" type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                required placeholder="Sesuai KTP"
                                class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-pink/40 focus:border-pastel-pink transition">
                        </div>
                    </div>

                    {{-- NIK & No. HP (2 Kolom di Desktop) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nik"
                                class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                NIK (Angka)
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-id-card text-lg"></i>
                                </span>
                                <input id="nik" type="number" name="nik" value="{{ old('nik') }}" required
                                    placeholder="16 digit NIK"
                                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-pink/40 focus:border-pastel-pink transition">
                            </div>
                        </div>

                        <div>
                            <label for="no_hp"
                                class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                No. HP
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-phone text-lg"></i>
                                </span>
                                <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}" required
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-pink/40 focus:border-pastel-pink transition">
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email"
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Email (Username)
                        </label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="bx bx-envelope text-lg"></i>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                placeholder="nama@email.com"
                                class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-pink/40 focus:border-pastel-pink transition">
                        </div>
                    </div>

                    {{-- Password & Konfirmasi (2 Kolom di Desktop) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="reg_password"
                                class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Password
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-lock text-lg"></i>
                                </span>
                                <input id="reg_password" type="password" name="password" required
                                    placeholder="Minimal 8 karakter"
                                    class="w-full pl-10 pr-10 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-pink/40 focus:border-pastel-pink transition">
                                <button type="button" onclick="togglePassword('reg_password', 'eye-reg-1')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                                    <i id="eye-reg-1" class="bx bx-eye text-lg"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="reg_password_confirm"
                                class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Konfirmasi
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="bx bx-check-shield text-lg"></i>
                                </span>
                                <input id="reg_password_confirm" type="password" name="password_confirmation" required
                                    placeholder="Ulangi password"
                                    class="w-full pl-10 pr-10 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-pink/40 focus:border-pastel-pink transition">
                                <button type="button" onclick="togglePassword('reg_password_confirm', 'eye-reg-2')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                                    <i id="eye-reg-2" class="bx bx-eye text-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full mt-2 flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-pastel-pink/85 hover:bg-pastel-pink text-slate-800 font-bold text-sm shadow-sm hover:shadow transition-all duration-200 active:scale-[0.99] cursor-pointer">
                        <span>Daftar</span>
                    </button>
                </form>

                {{-- Footer Link --}}
                <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="font-bold text-slate-800 px-2 py-0.5 rounded-lg bg-pastel-blue/60 hover:bg-pastel-blue transition">
                            Login di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bx-eye', 'bx-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bx-eye-slash', 'bx-eye');
            }
        }
    </script>
@endsection
