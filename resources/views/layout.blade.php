<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>i-KOTA</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Optional: Tambahan icon Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <nav class="bg-blue-600 text-white py-4 shadow-md">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <h1 class="text-xl font-bold">i-KOTA</h1>
        <a href="{{ url('/') }}" class="hover:text-yellow-200 transition font-semibold">BERANDA</a>
    </div>
    </nav>

    <main class="flex-grow container mx-auto p-6">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-gray-300 py-3 text-center text-sm">
        &copy; {{ date('Y') }} Pemerintah Kota - Sistem Layanan Publik
    </footer>

</body>
</html>
