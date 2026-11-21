@extends('layouts.app')
@section('title', 'Daftar Penyewa')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow mt-6">
        <h1 class="text-xl font-bold mb-4">Registrasi Penyewa Baru</h1>
        <form action="{{ route('register.post') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">NIK (Angka)</label>
                <input type="number" name="nik" value="{{ old('nik') }}" required
                    class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                    class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                    class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Email (Username)</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full border rounded px-3 py-2">
            </div>
            <button type="submit" class="w-full bg-teal-700 text-white py-2 rounded hover:bg-teal-800">Daftar</button>
        </form>
        <p class="text-sm text-center mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-teal-700 underline">Login</a>
        </p>
    </div>
@endsection
