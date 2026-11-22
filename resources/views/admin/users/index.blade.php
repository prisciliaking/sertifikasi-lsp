@extends('layouts.app')
@section('title', 'Validasi Penyewa')

@section('content')
    <div class="space-y-4">

        {{-- Page Header & Ringkasan Status --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-slate-800">
                    Validasi Pendaftar
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Terima atau tolak pendaftar sesuai dengan kelengkapan data dan persyaratan.
                </p>
            </div>

            {{-- Summary Pills (Compact) --}}
            <div class="flex flex-wrap items-center gap-1.5">
                <div
                    class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/80 backdrop-blur-md border border-white shadow-soft text-xs font-semibold text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-pastel-cream"></span>
                    <span>Menunggu:</span>
                    <strong
                        class="text-slate-800">{{ $penyewaList->whereNotIn('status_validasi', ['diterima', 'ditolak'])->count() }}</strong>
                </div>
                <div
                    class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/80 backdrop-blur-md border border-white shadow-soft text-xs font-semibold text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-pastel-blue"></span>
                    <span>Diterima:</span>
                    <strong
                        class="text-slate-800">{{ $penyewaList->where('status_validasi', 'diterima')->count() }}</strong>
                </div>
                <div
                    class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/80 backdrop-blur-md border border-white shadow-soft text-xs font-semibold text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-pastel-pink"></span>
                    <span>Ditolak:</span>
                    <strong class="text-slate-800">{{ $penyewaList->where('status_validasi', 'ditolak')->count() }}</strong>
                </div>
            </div>
        </div>

        {{-- Grid Cards Penyewa --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($penyewaList as $p)
                <div
                    class="bg-white/80 backdrop-blur-xl border border-white rounded-2xl shadow-soft overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow duration-200">

                    {{-- Top Accent Strip sesuai Status --}}
                    <div
                        class="h-1 w-full {{ $p->status_validasi === 'diterima' ? 'bg-pastel-blue' : ($p->status_validasi === 'ditolak' ? 'bg-pastel-pink' : 'bg-pastel-cream') }}">
                    </div>

                    <div class="p-4 space-y-3">
                        {{-- Header Card: Avatar, Nama, Status --}}
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div
                                    class="w-9 h-9 rounded-full bg-gradient-to-br from-pastel-cream to-pastel-pink/70 flex items-center justify-center text-xs font-extrabold text-slate-700 shrink-0 shadow-xs">
                                    {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <h2 class="font-bold text-sm text-slate-800 truncate" title="{{ $p->nama_lengkap }}">
                                        {{ $p->nama_lengkap }}
                                    </h2>
                                    <span class="font-mono text-[11px] text-slate-500 block">
                                        NIK: {{ $p->nik }}
                                    </span>
                                </div>
                            </div>

                            {{-- Status Badge --}}
                            @if ($p->status_validasi === 'diterima')
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-pastel-blue/70 text-slate-800 text-[10px] font-bold uppercase tracking-wide shrink-0">
                                    <i class="bx bx-check-circle text-xs"></i>
                                    {{ $p->status_validasi }}
                                </span>
                            @elseif ($p->status_validasi === 'ditolak')
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-pastel-pink/70 text-slate-800 text-[10px] font-bold uppercase tracking-wide shrink-0">
                                    <i class="bx bx-x-circle text-xs"></i>
                                    {{ $p->status_validasi }}
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-pastel-cream text-slate-800 text-[10px] font-bold uppercase tracking-wide shrink-0">
                                    <i class="bx bx-clock-3 text-xs"></i>
                                    {{ $p->status_validasi }}
                                </span>
                            @endif
                        </div>

                        {{-- Info Kontak (Compact) --}}
                        <div
                            class="px-3 py-2 rounded-xl bg-slate-50/80 border border-slate-100 space-y-1 text-xs text-slate-600">
                            <div class="flex items-center gap-2">
                                <i class="bx bx-phone text-sm text-slate-400 shrink-0"></i>
                                <span class="font-medium text-slate-700 truncate">{{ $p->no_hp }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="bx bx-envelope text-sm text-slate-400 shrink-0"></i>
                                <span class="truncate" title="{{ $p->email }}">{{ $p->email }}</span>
                            </div>
                        </div>

                        {{-- Action Buttons (Rounded Full) --}}
                        <div class="flex items-center gap-2 pt-1">
                            @if ($p->status_validasi !== 'diterima')
                                <form action="{{ route('admin.users.update-status', $p->nik) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_validasi" value="diterima">
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-full bg-pastel-blue/85 hover:bg-pastel-blue text-slate-800 text-xs font-bold shadow-xs transition-all active:scale-95 cursor-pointer">
                                        <i class="bx bx-check text-base"></i>
                                        <span>Terima</span>
                                    </button>
                                </form>
                            @endif

                            @if ($p->status_validasi !== 'ditolak')
                                <form action="{{ route('admin.users.update-status', $p->nik) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_validasi" value="ditolak">
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-full bg-pastel-pink/75 hover:bg-pastel-pink text-slate-800 text-xs font-bold shadow-xs transition-all active:scale-95 cursor-pointer">
                                        <i class="bx bx-x text-base"></i>
                                        <span>Tolak</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full bg-white/80 backdrop-blur-xl border border-white rounded-2xl shadow-soft py-10 px-4 text-center">
                    <div
                        class="w-12 h-12 mx-auto mb-2.5 rounded-full bg-pastel-cream/70 flex items-center justify-center text-slate-500">
                        <i class="bx bx-user-x text-2xl"></i>
                    </div>
                    <p class="font-bold text-slate-700 text-sm">Belum ada pendaftar penyewa</p>
                    <p class="text-xs text-slate-400 mt-0.5">Data pendaftar baru akan otomatis muncul di sini.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
