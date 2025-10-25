@extends('layout')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
  <h1 class="text-2xl font-bold text-blue-700 mb-6">🏥 Dinas Kesehatan</h1>

  <div class="flex gap-2 mb-6">
    <input type="text" placeholder="Masukkan Nama Faskes (Contoh: RSUD Sentosa)" 
           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none">
    <button class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 transition">Cari</button>
  </div>

  <div class="bg-white p-6 rounded-xl shadow-md">
    <h2 class="font-bold text-lg mb-3">Informasi Fasilitas Kesehatan</h2>
    <ul class="space-y-2 text-gray-700">
      <li><strong>Nama Faskes:</strong> Rumah Sakit Umum Daerah (RSUD) Sentosa</li>
      <li><strong>Jenis Faskes:</strong> Rumah Sakit Pemerintah Tipe C</li>
      <li><strong>Alamat Faskes:</strong> Jl. Kesehatan No. 1, Pusat Kab.</li>
      <li><strong>Jumlah Dokter:</strong> 35</li>
      <li><strong>Jumlah Perawat:</strong> 110</li>
      <li><strong>Jumlah Bidan:</strong> 25</li>
    </ul>
  </div>
</div>
@endsection
