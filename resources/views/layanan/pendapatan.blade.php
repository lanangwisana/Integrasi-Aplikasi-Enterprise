@extends('layout')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
  <h1 class="text-2xl font-bold text-red-700 mb-6">💰 Dinas Pendapatan Daerah</h1>

  <div class="flex gap-2 mb-6">
    <input type="text" placeholder="Masukkan Nama WP (Contoh: Ni Made Ayu Wira Salindri)" 
           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-red-400 focus:outline-none">
    <button class="bg-red-600 text-white px-5 py-3 rounded-lg hover:bg-red-700 transition">Cari</button>
  </div>

  <div class="bg-white p-6 rounded-xl shadow-md">
    <h2 class="font-bold text-lg mb-3">Informasi Wajib Pajak</h2>
    <ul class="space-y-2 text-gray-700">
      <li><strong>Nama WP:</strong> Ni Made Ayu Wira Salindri</li>
      <li><strong>Alamat WP:</strong> Jalan Kenanga No. 15, Bali</li>
      <li><strong>Jenis Pajak Terdaftar:</strong> PBB, Pajak Reklame</li>
      <li><strong>Status Pembayaran Terakhir:</strong> Lunas (ID: BAY010)</li>
      <li><strong>Tanggal Pembayaran Terakhir:</strong> 2025-10-20</li>
      <li><strong>Jumlah Pembayaran Terakhir:</strong> Rp 500.000</li>
    </ul>
  </div>
</div>
@endsection
