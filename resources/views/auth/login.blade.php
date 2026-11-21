@extends('layouts.app')
@section('title', 'Login')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow mt-10">
        <h1 class="text-xl font-bold mb-4">Login Sewa Garasi</h1>
        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required class="w-full border rounded px-3 py-2">
            </div>
            <button type="submit" class="w-full bg-teal-700 text-white py-2 rounded hover:bg-teal-800">Masuk</button>
        </form>
        <p class="text-sm text-center mt-4">
            Belum punya akun? <a href="{{ route('register') }}" class="text-teal-700 underline">Daftar Penyewa</a>
        </p>
    </div>
@endsection
