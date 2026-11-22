@extends('layouts.app')
@section('title', 'Login')

@section('content')
    <div class="min-h-[75vh] flex items-center justify-center py-6">
        <div
            class="w-full max-w-md bg-white/80 backdrop-blur-xl border border-white rounded-3xl shadow-soft overflow-hidden">

            {{-- Top Pastel Accent Bar --}}
            <div class="h-2 w-full bg-gradient-to-r from-pastel-cream via-pastel-pink to-pastel-blue"></div>

            <div class="p-8 sm:p-9">
                {{-- Header & Brand Icon --}}
                <div class="text-center mb-7">
                    <div
                        class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-pastel-blue/80 via-pastel-cream/80 to-pastel-pink/80 p-[1.5px] shadow-sm">
                        <div
                            class="w-full h-full bg-white/90 rounded-[14px] flex items-center justify-center text-slate-800">
                            <i class="bx bx-car text-3xl"></i>
                        </div>
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Selamat Datang</h1>
                    <p class="text-sm text-slate-500 mt-1">Masuk ke akun <span class="font-semibold text-slate-700">Sewa
                            Garasi</span> Anda</p>
                </div>

                {{-- Login Form --}}
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email"
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Email
                        </label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="bx bx-envelope text-lg"></i>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus placeholder="nama@email.com"
                                class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password"
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="bx bx-lock text-lg"></i>
                            </span>
                            <input id="password" type="password" name="password" required placeholder="Masukkan password"
                                class="w-full pl-10 pr-11 py-2.5 text-sm bg-white/90 border border-slate-200/80 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-pastel-blue/50 focus:border-pastel-blue transition">
                            <button type="button" onclick="togglePassword('password', 'eye-login')"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                                <i id="eye-login" class="bx bx-eye text-lg"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full mt-2 flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-pastel-blue hover:bg-[#b5d4ec] text-slate-800 font-bold text-sm shadow-sm hover:shadow transition-all duration-200 active:scale-[0.99] cursor-pointer">
                        <span>Masuk</span>
                        <i class="bx bx-arrow-right-stroke text-xl"></i>
                    </button>
                </form>

                {{-- Footer Link --}}
                <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="font-bold text-slate-800 px-2 py-0.5 rounded-lg bg-pastel-cream/70 hover:bg-pastel-cream transition">
                            Daftar Akun
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
