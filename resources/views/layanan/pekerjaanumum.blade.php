@extends('layout')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
  <h1 class="text-2xl font-bold text-green-700 mb-6">🚧 Dinas Pekerjaan Umum</h1>

  <div class="flex gap-2 mb-6">
    <input type="text" placeholder="Masukkan Nama Proyek (Contoh: Pembangunan Jembatan Kali Citarum)" 
           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-400 focus:outline-none">
    <button class="bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700 transition">Cari</button>
  </div>

  <div class="bg-white p-6 rounded-xl shadow-md">
    <h2 class="font-bold text-lg mb-3">Informasi Proyek</h2>
    <ul class="space-y-2 text-gray-700">
      <li><strong>Nama Proyek:</strong> Pembangunan Jembatan Kali Citarum</li>
      <li><strong>Bidang Proyek:</strong> Infrastruktur Air</li>
      <li><strong>Lokasi Proyek:</strong> Desa Mekar Sari (Koordinat: -6.9, 107.6)</li>
      <li><strong>Tahun Proyek:</strong> 2025</li>
      <li><strong>Status Proyek:</strong> Aktif (Progres 75%)</li>
    </ul>
  </div>
</div>
@endsection
