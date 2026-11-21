<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sewa Garasi')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen">
    @auth
        <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <div class="font-bold text-lg text-teal-700">Sewa Garasi</div>
            <div class="flex items-center gap-4 text-sm">
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}" class="hover:text-teal-700 font-medium">Validasi Penyewa</a>
                    <a href="{{ route('admin.garasi.index') }}" class="hover:text-teal-700 font-medium">Kelola Garasi</a>
                    <a href="{{ route('admin.perpanjangan.index') }}" class="hover:text-teal-700 font-medium">Perpanjangan</a>
                    <a href="{{ route('admin.laporan.index') }}" class="hover:text-teal-700 font-medium">Laporan</a>
                @else
                    <a href="{{ route('penyewa.dashboard') }}" class="hover:text-teal-700 font-medium">Dashboard</a>
                @endif
                <span class="text-gray-500">| {{ auth()->user()->nama_lengkap }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline font-medium">Logout</button>
                </form>
            </div>
        </nav>
    @endauth

    <main class="max-w-5xl mx-auto p-6">
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800 text-sm">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>

</html>
