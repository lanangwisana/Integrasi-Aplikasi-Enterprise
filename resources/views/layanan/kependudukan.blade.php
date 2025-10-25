@extends('layout')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
  <h1 class="text-2xl font-bold text-yellow-600 mb-6">🧾 Dinas Kependudukan</h1>

  <div class="flex gap-2 mb-6">
    <input type="text" placeholder="Masukkan Nama Pemohon (Contoh: Putri Puspita)" 
           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
    <button class="bg-yellow-500 text-gray-900 px-5 py-3 rounded-lg hover:bg-yellow-600 transition">Cari</button>
  </div>

  <div class="bg-white p-6 rounded-xl shadow-md">
    <h2 class="font-bold text-lg mb-3">Informasi Layanan Kependudukan</h2>
    <ul class="space-y-2 text-gray-700">
      <li><strong>Nama Pemohon:</strong> Putri Puspita</li>
      <li><strong>Jenis Layanan:</strong> Pengurusan Akta Kelahiran Anak</li>
      <li><strong>Tanggal Pengajuan:</strong> 2025-05-10</li>
      <li><strong>Status Layanan:</strong> Dalam Proses (Menunggu Verifikasi Persyaratan)</li>
      <li><strong>Dokumen Persyaratan:</strong> KK Terbaru: Lengkap</li>
    </ul>
  </div>
</div>
@endsection
