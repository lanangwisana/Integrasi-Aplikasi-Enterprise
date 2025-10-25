<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white p-6">
            <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>
            <nav class="space-y-2">
                <a href="{{ url('admin/dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Dashboard</a>
                <a href="{{ url('admin/wajib-pajak') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Wajib Pajak</a>
                <a href="{{ url('admin/pembayaran') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Pembayaran</a>
                <a href="{{ url('admin/informasi-proyek') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Proyek PU</a>
                <a href="{{ url('admin/fasilitas-kesehatan') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Kesehatan</a>
                <a href="{{ url('admin/tenaga-medis') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Tenaga Medis</a>
                <a href="{{ url('admin/layanan') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Kependudukan</a>
                <a href="{{ url('admin/persyaratan') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Persyaratan</a>
                <a href="{{ url('admin/reports') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Laporan</a>
                <a href="{{ url('admin/search') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Pencarian NIK</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
