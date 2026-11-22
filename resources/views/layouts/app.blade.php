<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sewa Garasi')</title>

    {{-- Google Font: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Boxicons v3 --}}
    <link href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css" rel="stylesheet">

    {{-- Tailwind CSS CDN + Palet Warna Kustom --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        pastel: {
                            cream: '#FAEDCB',
                            pink: '#F2C6DE',
                            blue: '#C6DEF1',
                        }
                    },
                    boxShadow: {
                        'soft': '0 10px 30px -10px rgba(15, 23, 42, 0.06)',
                        'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.05)',
                    }
                }
            }
        }
    </script>

    <style>
        /* Haluskan transisi halaman & scrollbar */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #FAF9F6;
        }

        ::-webkit-scrollbar-thumb {
            background: #C6DEF1;
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8cbe8;
        }
    </style>
</head>

<body
    class="relative bg-[#FCFBF8] text-slate-800 min-h-screen flex flex-col font-sans antialiased selection:bg-pastel-pink/60 selection:text-slate-900 overflow-x-hidden">

    {{-- Latar Belakang Pastel Halus --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-pastel-cream/70 blur-3xl opacity-80"></div>
        <div class="absolute top-1/3 -right-24 w-96 h-96 rounded-full bg-pastel-pink/55 blur-3xl opacity-75"></div>
        <div
            class="absolute -bottom-24 left-1/3 w-[28rem] h-[28rem] rounded-full bg-pastel-blue/65 blur-3xl opacity-75">
        </div>
    </div>

    @auth
        {{-- Navigasi Melayang --}}
        <header class="sticky top-4 z-50 px-4 sm:px-6">
            <nav
                class="max-w-6xl mx-auto bg-white/75 backdrop-blur-xl border border-white/80 rounded-3xl shadow-glass px-4 sm:px-5 py-2.5 flex flex-wrap justify-between items-center gap-3">

                {{-- Logo & Nama Aplikasi --}}
                <a href="{{ auth()->user()->isAdmin() ? route('admin.garasi.index') : route('penyewa.dashboard') }}"
                    class="flex items-center gap-2.5 group">
                    <div
                        class="relative w-10 h-10 rounded-full bg-gradient-to-br from-pastel-blue via-pastel-cream to-pastel-pink p-[1.5px] shadow-sm transition-transform duration-300 group-hover:scale-105">
                        <div class="w-full h-full bg-white/90 rounded-full flex items-center justify-center text-slate-800">
                            <i class="bx bx-car text-xl"></i>
                        </div>
                    </div>
                    <span class="font-extrabold text-base tracking-tight text-slate-800 leading-tight">
                        Sewa Garasi
                    </span>
                </a>

                {{-- Menu Navigasi (Pill) --}}
                <div
                    class="flex flex-wrap items-center gap-1 bg-slate-100/60 p-1 rounded-full border border-slate-200/50 text-xs sm:text-sm">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-1.5 px-4 py-1.5 rounded-full font-semibold transition-all duration-200 active:scale-95 {{ request()->routeIs('admin.users.*') ? 'bg-pastel-blue text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-pastel-cream/60' }}">
                            <i
                                class="bx bx-user-check text-base {{ request()->routeIs('admin.users.*') ? 'text-slate-900' : 'text-slate-400' }}"></i>
                            <span>Validasi</span>
                        </a>

                        <a href="{{ route('admin.garasi.index') }}"
                            class="flex items-center gap-1.5 px-4 py-1.5 rounded-full font-semibold transition-all duration-200 active:scale-95 {{ request()->routeIs('admin.garasi.*') ? 'bg-pastel-blue text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-pastel-cream/60' }}">
                            <i
                                class="bx bx-home-alt text-base {{ request()->routeIs('admin.garasi.*') ? 'text-slate-900' : 'text-slate-400' }}"></i>
                            <span>Garasi</span>
                        </a>

                        <a href="{{ route('admin.perpanjangan.index') }}"
                            class="flex items-center gap-1.5 px-4 py-1.5 rounded-full font-semibold transition-all duration-200 active:scale-95 {{ request()->routeIs('admin.perpanjangan.*') ? 'bg-pastel-blue text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-pastel-cream/60' }}">
                            <i
                                class="bx bx-calendar-plus text-base {{ request()->routeIs('admin.perpanjangan.*') ? 'text-slate-900' : 'text-slate-400' }}"></i>
                            <span>Perpanjangan</span>
                        </a>

                        <a href="{{ route('admin.laporan.index') }}"
                            class="flex items-center gap-1.5 px-4 py-1.5 rounded-full font-semibold transition-all duration-200 active:scale-95 {{ request()->routeIs('admin.laporan.*') ? 'bg-pastel-blue text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-pastel-cream/60' }}">
                            <i
                                class="bx bx-bar-chart-square text-base {{ request()->routeIs('admin.laporan.*') ? 'text-slate-900' : 'text-slate-400' }}"></i>
                            <span>Laporan</span>
                        </a>
                    @else
                        <a href="{{ route('penyewa.dashboard') }}"
                            class="flex items-center gap-1.5 px-4 py-1.5 rounded-full font-semibold transition-all duration-200 active:scale-95 {{ request()->routeIs('penyewa.dashboard') ? 'bg-pastel-blue text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-pastel-cream/60' }}">
                            <i class="bx bx-dashboard text-base"></i>
                            <span>Beranda</span>
                        </a>
                    @endif
                </div>

                {{-- Dropdown Profil Pengguna --}}
                <div class="relative" id="profile-dropdown-wrapper">
                    <button type="button" id="profile-menu-button" aria-expanded="false" aria-haspopup="true"
                        class="flex items-center gap-2 pl-1.5 pr-3 py-1 rounded-full bg-pastel-cream/75 hover:bg-pastel-cream border border-white shadow-sm transition-all duration-200 cursor-pointer active:scale-95">
                        <div
                            class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-xs font-bold text-slate-700 shadow-xs">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}
                        </div>
                        <span class="font-semibold text-xs text-slate-700 max-w-[120px] truncate">
                            {{ auth()->user()->nama_lengkap }}
                        </span>
                        <i id="profile-chevron"
                            class="bx bx-chevron-down text-base text-slate-500 transition-transform duration-200"></i>
                    </button>

                    {{-- Menu Dropdown --}}
                    <div id="profile-menu"
                        class="hidden absolute right-0 mt-2 w-52 bg-white/95 backdrop-blur-xl border border-white rounded-2xl shadow-soft p-2 z-50 origin-top-right">
                        <div class="px-3 py-2 border-b border-slate-100">
                            <p class="text-xs font-bold text-slate-800 truncate">
                                {{ auth()->user()->nama_lengkap }}
                            </p>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-1.5 px-4 py-2 rounded-full bg-pastel-pink/65 hover:bg-pastel-pink text-xs font-bold text-slate-800 transition-all duration-200 active:scale-95 cursor-pointer">
                                <i class="bx bx-arrow-out-right-square-half text-base"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>
    @endauth

    {{-- Konten Utama --}}
    <main class="max-w-6xl w-full mx-auto px-4 sm:px-6 pt-8 pb-12 flex-1 animate-fade-up">

        {{-- Notifikasi Berhasil --}}
        @if (session('success'))
            <div id="alert-success"
                class="mb-6 flex items-center justify-between gap-3 px-4 py-3 rounded-2xl bg-white/85 backdrop-blur-md border border-pastel-blue shadow-soft text-slate-800 text-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-pastel-blue/70 flex items-center justify-center shrink-0">
                        <i class="bx bx-check text-xl text-slate-800"></i>
                    </div>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
                <button type="button" title="Tutup" onclick="this.parentElement.remove()"
                    class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition cursor-pointer">
                    <i class="bx bx-x text-lg"></i>
                </button>
            </div>
        @endif

        {{-- Notifikasi Kesalahan Validasi --}}
        @if ($errors->any())
            <div id="alert-error"
                class="mb-6 flex items-start justify-between gap-3 px-4 py-3 rounded-2xl bg-white/85 backdrop-blur-md border border-pastel-pink shadow-soft text-slate-800 text-sm">
                <div class="flex items-start gap-3">
                    <div
                        class="w-8 h-8 rounded-full bg-pastel-pink/70 flex items-center justify-center shrink-0 mt-0.5">
                        <i class="bx bx-error-circle text-xl text-slate-800"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 mb-1">Periksa kembali data yang dimasukkan:</p>
                        <ul class="list-disc pl-4 space-y-0.5 text-slate-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" title="Tutup" onclick="this.parentElement.remove()"
                    class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition cursor-pointer">
                    <i class="bx bx-x text-lg"></i>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    @auth
        <footer class="py-5 text-center text-xs text-slate-400">
            <span class="px-4 py-1.5 rounded-full bg-white/60 backdrop-blur-sm border border-white/80">
                &copy; {{ date('Y') }} <strong class="text-slate-600 font-semibold">Sewa Garasi</strong>
            </span>
        </footer>

        {{-- Script Dropdown Profil --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const wrapper = document.getElementById('profile-dropdown-wrapper');
                const btn = document.getElementById('profile-menu-button');
                const menu = document.getElementById('profile-menu');
                const chevron = document.getElementById('profile-chevron');

                if (!btn || !menu) return;

                const toggleMenu = (forceClose = false) => {
                    const isHidden = menu.classList.contains('hidden');
                    const shouldOpen = !forceClose && isHidden;

                    menu.classList.toggle('hidden', !shouldOpen);
                    chevron.classList.toggle('rotate-180', shouldOpen);
                    btn.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
                };

                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleMenu();
                });

                document.addEventListener('click', (e) => {
                    if (!wrapper.contains(e.target)) {
                        toggleMenu(true);
                    }
                });

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        toggleMenu(true);
                    }
                });
            });
        </script>
    @endauth

    @stack('modals')
</body>

</html>
