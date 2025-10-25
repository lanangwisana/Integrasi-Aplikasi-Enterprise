@extends('layout')

@section('content')
<div class="text-center mt-10 mb-16">
  <h1 class="text-4xl font-extrabold mb-10 text-blue-700 tracking-wider">
    Pilih Layanan Dinas
  </h1>

  <div class="grid grid-cols-2 gap-10 px-16">
    <!-- Dinas Pendapatan -->
    <a href="{{ route('layanan.pendapatan') }}"
       class="bg-gradient-to-r from-red-500 to-red-600 text-white py-10 px-8 text-xl font-bold rounded-3xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition duration-300 ease-in-out">
       💰 Dinas Pendapatan Daerah
    </a>

    <!-- Dinas Pekerjaan Umum -->
    <a href="{{ route('layanan.pekerjaanumum') }}"
       class="bg-gradient-to-r from-green-500 to-green-600 text-white py-10 px-8 text-xl font-bold rounded-3xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition duration-300 ease-in-out">
       🚧 Dinas Pekerjaan Umum
    </a>

    <!-- Dinas Kesehatan -->
    <a href="{{ route('layanan.kesehatan') }}"
       class="bg-gradient-to-r from-blue-500 to-blue-600 text-white py-10 px-8 text-xl font-bold rounded-3xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition duration-300 ease-in-out">
       🏥 Dinas Kesehatan
    </a>

    <!-- Dinas Kependudukan -->
    <a href="{{ route('layanan.kependudukan') }}"
       class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 py-10 px-8 text-xl font-bold rounded-3xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition duration-300 ease-in-out">
       🧾 Dinas Kependudukan
    </a>
  </div>
</div>
@endsection
