<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard iKota</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Custom style for active tab */
    .tab-active {
        /* Tailwind classes mapped: border-blue-500, text-gray-800, font-semibold */
        border-bottom-color: #3b82f6 !important; /* Blue-500 */
        color: #1f2937 !important; /* Gray-800 */
        font-weight: 600 !important;
    }
    /* Mengatur tinggi konsisten untuk chart */
    .chart-container {
        height: 20rem; /* Ketinggian seragam untuk semua grafik utama */
    }
</style>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="min-h-screen p-6 md:p-10 lg:p-12">
    <h1 class="text-3xl lg:text-4xl font-extrabold mb-8 text-gray-900 border-b pb-4">🏠 Dashboard iKota</h1>

    <div class="bg-white p-4 rounded-xl shadow-lg mb-8">
        <h2 class="text-xl font-semibold mb-3 text-gray-700">Filter Dinas</h2>
        <ul class="flex overflow-x-auto space-x-6" id="dinasTabs">
            <li class="pb-2 border-b-2 border-transparent cursor-pointer text-gray-600 hover:text-gray-800 transition tab-active" data-dinas="pendapatan">Dinas Pendapatan Daerah</li>
            <li class="pb-2 border-b-2 border-transparent cursor-pointer text-gray-600 hover:text-gray-800 transition" data-dinas="pekerjaan-umum">Dinas Pekerjaan Umum</li>
            <li class="pb-2 border-b-2 border-transparent cursor-pointer text-gray-600 hover:text-gray-800 transition" data-dinas="kesehatan">Dinas Kesehatan</li>
            <li class="pb-2 border-b-2 border-transparent cursor-pointer text-gray-600 hover:text-gray-800 transition" data-dinas="kependudukan">Dinas Kependudukan</li>
        </ul>
    </div>

    <div id="widgetContainer">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10 dinasWidget" data-dinas="pendapatan">
            
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl lg:col-span-3">
                <h2 class="text-xl font-bold mb-4 text-gray-800">🔍 Cek Status Wajib Pajak (via ID Wajib Pajak)</h2>
                <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3">
                    <input type="text" id="nikInputPendapatan" placeholder="Contoh: Masukkan ID Wajib Pajak WPX001" class="border border-gray-300 p-3 rounded-lg w-full md:w-3/4 focus:ring-blue-500 focus:border-blue-500">
                    <button onclick="handleSearch('pendapatan', 'pajak')" class="bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition w-full md:w-1/4">Cari Data Pajak</button>
                </div>
                
                <ul class="flex border-b border-gray-200 mt-6 mb-4" id="nikTabs-pendapatan">
                    <li class="pb-2 border-b-2 border-blue-500 cursor-pointer font-semibold text-gray-700" data-tab="pajak">Hasil Pencarian Wajib Pajak</li>
                </ul>

                <div id="nikContent-pendapatan" class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-600">Hasil pencarian ID Wajib Pajak (Data Pajak) akan muncul di sini.</p>
                </div>
            </div>
            
            <!-- Total Pendapatan Pajak -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-blue-500 hover:shadow-2xl transition duration-300">
                <p class="text-sm font-medium text-blue-600 uppercase mb-2">Total Pendapatan Pajak</p>
                <p class="text-4xl font-bold text-gray-900">Rp {{ number_format($statistik_dinpenda['totalPendapatan'] ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-2">Target 100% Tercapai</p>
            </div>

            <!-- Wajib Pajak Terdaftar -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-teal-500 hover:shadow-2xl transition duration-300">
                <p class="text-sm font-medium text-teal-600 uppercase mb-2">Nilai Iklan Terpakai</p>
                <p class="text-4xl font-bold text-gray-900">{{ $statistik_dinpenda['jumlahWajibPajak'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-2">Data Real-time Setiap Minggu</p>
            </div>

            <!-- Jenis Pajak Terbanyak -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-green-500 hover:shadow-2xl transition duration-300">
                <p class="text-sm font-medium text-green-600 uppercase mb-2">Jenis Pajak Terbanyak</p>
                <p class="text-2xl font-bold text-gray-900">
                    {{ is_array($statistik_dinpenda['jenisPajakTerbanyak']) ? implode(' dan ', $statistik_dinpenda['jenisPajakTerbanyak']) : '-' }}
                </p>
                <p class="text-xs text-gray-500 mt-2">Berdasarkan Jumlah Iklan</p>
            </div>

            
            <div class="bg-blue-600 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition duration-300 lg:col-span-3">
                <h2 class="text-xl font-semibold mb-2">Grafik Tren Pembayaran Pajak (3 Bulan Terakhir)</h2>
                <div class="chart-container">
                    <canvas id="chartPendapatan"></canvas> 
                </div>
            </div>
            
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10 dinasWidget hidden" data-dinas="pekerjaan-umum">
            
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl md:col-span-4">
                <h2 class="text-xl font-bold mb-4 text-gray-800">🔍 Cari Proyek Detail (via ID/Nama Proyek)</h2>
                <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3">
                    <input type="text" id="inputProyekPU" placeholder="Contoh: Masukkan ID Proyek PU023" class="border border-gray-300 p-3 rounded-lg w-full md:w-3/4 focus:ring-purple-500 focus:border-purple-500">
                    <button onclick="handleSearch('pekerjaan-umum', 'proyek-detail')" class="bg-purple-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-purple-700 transition w-full md:w-1/4">Cari Proyek</button>
                </div>
                
                <ul class="flex border-b border-gray-200 mt-6 mb-4" id="tabs-proyek">
                    <li class="pb-2 border-b-2 border-purple-500 cursor-pointer font-semibold text-gray-700" data-tab="proyek-detail">Hasil Pencarian Proyek</li>
                </ul>

                <div id="content-proyek" class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-600">Hasil pencarian dummy Proyek akan muncul di sini.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-purple-500 hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-purple-600 uppercase mb-2">Proyek Aktif (Jumlah)</h2>
                <p class="text-4xl font-bold text-gray-900">{{ $statistik_pu['total_aktif'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Total Proyek yang sedang berjalan</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-pink-500 hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-pink-600 uppercase mb-2">Proyek Selesai (Jumlah)</h2>
                <p class="text-4xl font-bold text-gray-900">{{ $statistik_pu['total_selesai'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Total Proyek yang sudah selesai</p>
             </div>
             <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-red-500 hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-red-600 uppercase mb-2">Proyek Terlambat (Jumlah)</h2>
                <p class="text-4xl font-bold text-gray-900">{{ $statistik_pu['total_terlambat'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Perlu penanganan segera</p>
            </div>
            <div class="bg-purple-800 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-purple-200 uppercase mb-2">SEKTOR PROYEK TERBANYAK</h2>
                <p class="text-2xl font-bold">{{ $statistik_pu['bidang_terbanyak'] }}</p>
                <p class="text-xs text-purple-200 mt-2">Fokus pembangunan terbanyak</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-xl md:col-span-4">
                <h2 class="font-semibold mb-2 text-xl text-gray-700">Distribusi Status Proyek</h2>
                <div class="chart-container">
                    <canvas id="chartProyek"></canvas>
                </div>
            </div>
            
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-10 dinasWidget hidden" data-dinas="kesehatan">

            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl lg:col-span-4">
                <h2 class="text-xl font-bold mb-4 text-gray-800">🔍 Cari Data Fasilitas Kesehatan (Faskes)</h2>
                <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3">
                    <input type="text" id="nikInputKesehatan" placeholder="Contoh: Masukkan Nama Faskes RSUD Sentosa" class="border border-gray-300 p-3 rounded-lg w-full md:w-3/4 focus:ring-green-500 focus:border-green-500">
                    <button onclick="handleSearch('kesehatan', 'faskes-detail')" class="bg-green-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-700 transition w-full md:w-1/4">Cari Faskes</button>
                </div>
                
                <ul class="flex border-b border-gray-200 mt-6 mb-4" id="nikTabs-kesehatan">
                    <li class="pb-2 border-b-2 border-blue-500 cursor-pointer font-semibold text-gray-700" data-tab="faskes-detail">Hasil Pencarian Faskes</li>
                </ul>

                <div id="nikContent-kesehatan" class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-600">Hasil pencarian dummy Faskes akan muncul di sini.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-indigo-500 hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-indigo-600 uppercase mb-2">Dokter Tersedia</h2>
                <p class="text-4xl font-bold text-gray-900">{{ $statistik_faskes['dokter_tersedia'] ?? 0}}</p>
                <p class="text-xs text-gray-500 mt-2">Data Tenaga Medis</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-green-500 hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-green-600 uppercase mb-2">Perawat Tersedia</h2>
                <p class="text-4xl font-bold text-gray-900">{{ $statistik_faskes['perawat_tersedia'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-2">Data Tenaga Medis</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-yellow-500 hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-yellow-600 uppercase mb-2">Bidan Tersedia</h2>
                <p class="text-4xl font-bold text-gray-900">{{ $statistik_faskes['bidan_tersedia'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-2">Data Tenaga Medis</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-red-500 hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-red-600 uppercase mb-2">Faskes Terdaftar</h2>
                <p class="text-4xl font-bold text-gray-900">{{ $statistik_faskes['faskes_terdaftar'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-2">Total Fasilitas Kesehatan</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl lg:col-span-4">
                <h2 class="text-xl font-semibold mb-2 text-gray-800">Proporsi Tenaga Medis</h2>
                <div class="chart-container">
                    <canvas id="chartKesehatan"></canvas> 
                </div>
            </div>
            
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10 dinasWidget hidden" data-dinas="kependudukan">
            
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl lg:col-span-3">
                <h2 class="text-xl font-bold mb-4 text-gray-800">🔍 Cek Status Layanan Kependudukan (via ID Layanan)</h2>
                <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3">
                    <input type="text" id="inputLayananKependudukan" placeholder="Contoh: Masukkan ID Layanan LYN001" class="border border-gray-300 p-3 rounded-lg w-full md:w-3/4 focus:ring-orange-500 focus:border-orange-500">
                    <button onclick="handleSearch('kependudukan', 'layanan-detail')" 
                        class="bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-orange-700 transition w-full md:w-1/4">Cek Status</button>
                </div>

                <ul class="flex border-b border-gray-200 mt-6 mb-4" id="tabs-layanan">
                    <li class="pb-2 border-b-2 border-orange-500 cursor-pointer font-semibold text-gray-700" data-tab="layanan-detail">Hasil Cek Status Layanan</li>
                </ul>

                <div id="content-layanan" class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-600">Hasil pencarian Detail Layanan dan Persyaratan akan muncul di sini.</p>
                </div>
            </div>
            <!-- Total Layanan Masuk (Bulan Ini) -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-blue-500">
                <h2 class="font-semibold mb-2 text-sm text-blue-600 uppercase">Total Layanan Masuk (Bulan Ini)</h2>
                <p class="text-4xl font-bold text-gray-900">{{ $statistik_dinduk['totalLayananBulanIni'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-2">Dihitung dari Entitas Layanan</p>
            </div>

            <!-- Persentase Layanan Tertunda -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-red-500">
                <h2 class="font-semibold mb-2 text-sm text-red-600 uppercase">Persentase Layanan Tertunda</h2>
                <p class="text-4xl font-bold text-gray-900">{{ isset($statistik_dinduk['persentaseLayananTertunda']) ? $statistik_dinduk['persentaseLayananTertunda'] . '%' : '0%' }}</p>
                <p class="text-xs text-gray-500 mt-2">Karena kekurangan persyaratan</p>
            </div>

            <!-- Total Layanan Selesai -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-purple-500">
                <h2 class="font-semibold mb-2 text-sm text-purple-600 uppercase">Layanan Selesai</h2>
                <p class="text-4xl font-bold text-gray-900">{{ $statistik_dinduk['totalLayananSelesai'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-2">Total layanan yang sudah selesai</p>
            </div>            
            <div class="bg-white p-6 rounded-2xl shadow-xl lg:col-span-3">
                <h2 class="text-xl font-semibold mb-2 text-gray-800">5 Jenis Layanan Paling Banyak Diajukan</h2>
                <div class="chart-container">
                    <canvas id="chartLayananKependudukan"></canvas> 
                </div>
            </div>

        </div>
        </div>
    
</div>

<script>
// ==========================================================
// DATA DUMMY NIK/FASKES/PROYEK/LAYANAN
// ==========================================================
const dummyData = {
    
    // DINAS PENDAPATAN
    'pajak': {
        title: "Status Pajak Penduduk",
        data: [
            { key: "ID Wajib Pajak", value: "WPX001" }, 
            { key: "Nama WP", value: "Ni Made Ayu Wira Salindri" }, 
            { key: "Alamat WP", value: "Jalan Kenanga No. 15, Bali" }, 
            { key: "Jenis Pajak Terdaftar", value: "PBB, Pajak Reklame" }, 
            { key: "Status Pembayaran Terakhir", value: "Lunas (ID: BAY010)" }, 
            { key: "Tanggal Pembayaran Terakhir", value: "2025-10-20" }, 
            { key: "Jumlah Pembayaran Terakhir", value: "Rp 500.000" } 
        ]
    },

    // DINAS PEKERJAAN UMUM
    'proyek-detail': { 
        title: "Detail Proyek Infrastruktur",
        data: [
            { key: "ID Proyek", value: "PU023" }, 
            { key: "Nama Proyek", value: "Pembangunan Jembatan Kali Citarum" }, 
            { key: "Bidang Proyek", value: "Infrastruktur Air" },
            { key: "Lokasi Proyek", value: "Desa Mekar Sari (Koordinat: -6.9, 107.6)" },
            { key: "Tahun Proyek", value: "2025" },
            { key: "Status Proyek", value: "Aktif (Progres 75%)" }
        ]
    },
    
    // DINAS KESEHATAN
    'faskes-detail': { 
        title: "Detail Fasilitas Kesehatan",
        data: [
            { key: "Nama Faskes", value: "Rumah Sakit Umum Daerah (RSUD) Sentosa" }, 
            { key: "ID Faskes", value: "FK005" }, 
            { key: "Jenis Faskes", value: "Rumah Sakit Pemerintah Tipe C" }, 
            { key: "Alamat Faskes", value: "Jl. Kesehatan No. 1, Pusat Kab." }, 
            { key: "Jumlah Dokter", value: "35" }, 
            { key: "Jumlah Perawat", value: "110" }, 
            { key: "Jumlah Bidan", value: "20" } 
        ]
    },

    // DINAS KEPENDUDUKAN (Nama Pemohon sudah ditambahkan)
    'layanan-detail': {
        title: "Status Layanan & Persyaratan (ID: LYN001)",
        data: [
            { key: "ID Layanan", value: "LYN001" },
            { key: "Jenis Layanan", value: "Pengurusan Akta Kelahiran Anak" },
            { key: "Nama Pemohon", value: "<span class='font-bold text-gray-800'>Putri Puspita</span>" }, 
            { key: "Tanggal Pengajuan", value: "2025-05-10" },
            { key: "Status Layanan", value: "<span class='font-bold text-yellow-600'>Dalam Proses (Menunggu Verifikasi Persyaratan)</span>" },
            { key: "---", value: "---" },
            { key: "STATUS PERSYARATAN (Entitas Persyaratan)", value: "", type: "Header" },
            { key: "Dokumen KK Terbaru", value: "<span class='font-bold text-green-600'>Lengkap</span>" },
            { key: "Buku Nikah/Akta Perkawinan", value: "<span class='font-bold text-green-600'>Lengkap</span>" },
            { key: "Surat Keterangan Lahir", value: "<span class='font-bold text-red-600'>Belum Lengkap</span>" },
            { key: "KTP Elektronik Orang Tua", value: "<span class='font-bold text-green-600'>Lengkap</span>" }
        ]
    }
};

// Fungsi untuk membuat HTML konten pencarian
function createContentHtml(tabName) {
    const data = dummyData[tabName];
    if (!data) return `<p class="text-red-500">Data untuk tab ${tabName} tidak tersedia.</p>`;
    
    let html = `<h3 class="font-bold text-xl mb-3 text-gray-800 border-b pb-2">${data.title}</h3>`;
    
    data.data.forEach(item => {
        if (item.key === '---') {
            html += `<hr class="my-2 border-gray-300">`;
        } else if (item.type === 'Header') {
            html += `<p class="text-sm font-extrabold mt-3 mb-1 text-gray-700">${item.key}</p>`;
        } else {
            html += `<p class="text-base mb-1 text-gray-700"><span class="font-medium">${item.key}:</span> ${item.value}</p>`;
        }
    });
    return html;
}

function renderFaskesDetail(data) {
    if (!data || Object.keys(data).length === 0) {
        return `<p class="text-red-500">Data faskes tidak ditemukan.</p>`;
    }

    let html = `<h3 class="font-bold text-xl mb-3 text-gray-800 border-b pb-2">Detail Fasilitas Kesehatan</h3>`;
    for (const [key, value] of Object.entries(data)) {
        html += `<p class="text-base mb-1 text-gray-700"><span class="font-medium">${key}:</span> ${value}</p>`;
    }
    return `
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Detail Fasilitas Kesehatan</h3>
        <div class="grid grid-cols-1 md:grid-cols-1 gap-2 text-gray-700">
            <div><span class="font-semibold">Nama Faskes:</span> ${data['nama_faskes'] ?? '-'}</div>
            <div><span class="font-semibold">ID Faskes:</span> ${data['iD_faskes'] ?? '-'}</div>
            <div><span class="font-semibold">Jenis Faskes:</span> ${data['jenis_faskes'] ?? '-'}</div>
            <div><span class="font-semibold">Alamat Faskes:</span> ${data['alamat_faskes'] ?? '-'}</div>
            <div><span class="font-semibold">Jumlah Dokter:</span> ${data['dokter'] ?? 0}</div>
            <div><span class="font-semibold">Jumlah Perawat:</span> ${data['perawat'] ?? 0}</div>
            <div><span class="font-semibold">Jumlah Bidan:</span> ${data['bidan'] ?? 0}</div>
        </div>
    </div>`;
}

function renderProyekDetail(data) {
    if (!data || Object.keys(data).length === 0) {
        return `<p class="text-red-500">Data Proyek tidak ditemukan.</p>`;
    }

    let html = `<h3 class="font-bold text-xl mb-3 text-gray-800 border-b pb-2">Detail Proyek Umum</h3>`;
    for (const [key, value] of Object.entries(data)) {
        html += `<p class="text-base mb-1 text-gray-700"><span class="font-medium">${key}:</span> ${value}</p>`;
    }
    return `
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Detail Proyek Umum</h3>
        <div class="grid grid-cols-1 md:grid-cols-1 gap-2 text-gray-700">
            <div><span class="font-semibold">Nama Proyek:</span> ${data['nama'] ?? '-'}</div>
            <div><span class="font-semibold">ID Proyek:</span> ${data['id'] ?? '-'}</div>
            <div><span class="font-semibold">Bidang Proyek:</span> ${data['bidang'] ?? '-'}</div>
            <div><span class="font-semibold">Lokasi Proyek:</span> ${data['lokasi'] ?? '-'}</div>
            <div><span class="font-semibold">Tahun:</span> ${data['tahun'] ?? 0}</div>
            <div><span class="font-semibold">Status:</span> ${data['status'] ?? 0}</div>
        </div>
    </div>`;
}

function renderPendudukDetail(data) {
    if (!data || Object.keys(data).length === 0) {
        return `<p class="text-red-500">Data layanan tidak ditemukan.</p>`;
    }

    const status = data['status_Layanan'] ?? '-';
    let statusColor = 'text-gray-600';

    if (status.toLowerCase().includes('proses')) {
        statusColor = 'text-yellow-600';
    } else if (status.toLowerCase().includes('selesai')) {
        statusColor = 'text-green-600';
    } else if (status.toLowerCase().includes('tertunda')) {
        statusColor = 'text-red-600';
    }

    let html = `
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">
            Status Layanan & Persyaratan (ID: ${data['iD_Pengajuan'] ?? '-'})
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4 text-gray-700">
            <div><span class="font-semibold">ID Layanan:</span> ${data['iD_Pengajuan'] ?? '-'}</div>
            <div><span class="font-semibold">Jenis Layanan:</span> ${data['jenis_Layanan'] ?? '-'}</div>
            <div><span class="font-semibold">Nama Pemohon:</span> ${data['nama_pemohon'] ?? '-'}</div>
            <div><span class="font-semibold">Tanggal Pengajuan:</span> ${data['tanggal_Pengajuan']?.split('T')[0] ?? '-'}</div>
            <div><span class="font-semibold">Status Layanan:</span> <span class="${statusColor} font-bold">${status}</span></div>
        </div>`;

    if (Array.isArray(data['status_Persyaratan']) && data['status_Persyaratan'].length > 0) {
        html += `<h4 class="mt-6 mb-2 font-semibold text-gray-800">STATUS PERSYARATAN</h4>`;
        html += `<ul class="list-disc pl-5 text-gray-700">`;
        data['status_Persyaratan'].forEach(item => {
            const kelengkapan = item['status_Kelengkapan'] ?? '-';
            const warna = kelengkapan.toLowerCase() === 'lengkap' ? 'text-green-600' : 'text-red-600';
            html += `<li>${item['nama_Persyaratan']}: <span class="font-bold ${warna}">${kelengkapan}</span></li>`;
        });
        html += `</ul>`;
    }

    html += `</div>`;
    return html;
}

function renderPendapatanDetail(data) {
    if (!data || Object.keys(data).length === 0) {
        return `<p class="text-red-500">Data pajak tidak ditemukan.</p>`;
    }

    const tanggal = new Date(data['TANGGAL_PEMBAYARAN']).toLocaleDateString('id-ID');

    return `
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Status Pajak Wajib Pajak</h3>
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4 text-gray-700">
            <div><span class="font-semibold">ID Wajib Pajak:</span> ${data['ID_WAJIB_PAJAK']}</div>
            <div><span class="font-semibold">Nama WP:</span> ${data['NAMA_WP']}</div>
            <div><span class="font-semibold">Alamat WP:</span> ${data['ALAMAT_WP']}</div>
            <div><span class="font-semibold">Jenis Pajak:</span> ${data['JENIS_PAJAK']}</div>
            <div><span class="font-semibold">Status Pembayaran:</span> <span class="text-green-600 font-bold">${data['STATUS_PEMBAYARAN']}</span></div>
            <div><span class="font-semibold">ID Pembayaran Terakhir:</span> ${data['ID_PEMBAYARAN_TERAKHIR']}</div>
            <div><span class="font-semibold">Tanggal Pembayaran:</span> ${tanggal}</div>
            <div><span class="font-semibold">Jumlah Pembayaran:</span> Rp ${data['JUMLAH_PEMBAYARAN'].toLocaleString('id-ID')}</div>
        </div>
    </div>`;
}



// Fungsi untuk menangani pencarian/update
function handleSearch(dinasName, tabName) {
    let contentId;
    let targetTabName = tabName;

    if (dinasName === 'pekerjaan-umum') {
        contentId = 'content-proyek';
        targetTabName = 'proyek-detail';
    } else if (dinasName === 'kesehatan') {
        contentId = 'nikContent-kesehatan';
        targetTabName = 'faskes-detail'; 
    } else if (dinasName === 'pendapatan') {
        contentId = 'nikContent-pendapatan';
        targetTabName = 'pajak'; 
    } else if (dinasName === 'kependudukan') {
        contentId = 'content-layanan';
        targetTabName = 'layanan-detail'; 
    } else {
        return; 
    }

    const contentElement = document.getElementById(contentId);
    
    // Pendapatan daerah
    if (dinasName === 'pendapatan') {
    const nikValue = document.getElementById('nikInputPendapatan').value.trim();
    if (!nikValue) {
        contentElement.innerHTML = `<p class="text-yellow-600">Silakan masukkan ID Wajib Pajak terlebih dahulu.</p>`;
        return;
    }

        fetch(`/admin/pajak/detail?id=${encodeURIComponent(nikValue)}`)
            .then(res => res.json())
            .then(data => {
                contentElement.innerHTML = renderPendapatanDetail(data);
            })
            .catch(err => {
                contentElement.innerHTML = `<p class="text-red-500">Gagal ambil data pajak.</p>`;
                console.error(err);
            });
        return;
    }


    // Dinas Pekerjaan umum
    if (dinasName === 'pekerjaan-umum') {
    const proyekId = document.getElementById('inputProyekPU').value.trim();
    if (!proyekId) {
        contentElement.innerHTML = `<p class="text-yellow-600">Silakan masukkan ID Proyek terlebih dahulu.</p>`;
        return;
    }

    fetch(`/admin/proyek/detail?id=${encodeURIComponent(proyekId)}`)
        .then(res => res.json())
        .then(data => {
            contentElement.innerHTML = renderProyekDetail(data); 
        })
        .catch(err => {
            contentElement.innerHTML = `<p class="text-red-500">Gagal ambil data Pekerjaan Umum.</p>`;
            console.error(err);
        }
    );
    return;
    }

    // Dinas Kesehatan
    if (dinasName === 'kesehatan') {
        contentId = 'nikContent-kesehatan';
        const namaFaskes = document.getElementById('nikInputKesehatan').value.trim();

        if (!namaFaskes) {
            contentElement.innerHTML = `<p class="text-yellow-600">Silakan masukkan nama faskes terlebih dahulu.</p>`;
            return;
        }

        fetch(`/admin/faskes/detail?nama=${encodeURIComponent(namaFaskes)}`)
            .then(res => res.json())
            .then(data => {
                contentElement.innerHTML = renderFaskesDetail(data);
            })
            .catch(err => {
                contentElement.innerHTML = `<p class="text-red-500">Gagal ambil data faskes.</p>`;
                console.error(err);
            }
        );
    return;
    }

    // Dinas Kependudukan 
    if (dinasName === 'kependudukan') {
        const layananId = document.getElementById('inputLayananKependudukan').value.trim();
        if (!layananId) {
            contentElement.innerHTML = `<p class="text-yellow-600">Silakan masukkan ID Layanan terlebih dahulu.</p>`;
            return;
        }

        fetch(`/admin/penduduk/detail?id=${encodeURIComponent(layananId)}`)
            .then(res => res.json())
            .then(data => {
                contentElement.innerHTML = renderPendudukDetail(data);
            })
            .catch(err => {
                contentElement.innerHTML = `<p class="text-red-500">Gagal ambil data layanan kependudukan.</p>`;
                console.error(err);
            });
        return;
    }
}




// ==========================================================
// A. Filter Dinas (Main Content)
// ==========================================================
const dinasTabs = document.querySelectorAll('#dinasTabs li');
const dinasWidgets = document.querySelectorAll('.dinasWidget');
const inputMap = [
    { dinas: 'pendapatan', tab: 'pajak', inputId: 'nikInputPendapatan' },
    { dinas: 'pekerjaan-umum', tab: 'proyek-detail', inputId: 'inputProyekPU' }, 
    { dinas: 'kesehatan', tab: 'faskes-detail', inputId: 'nikInputKesehatan' },
    { dinas: 'kependudukan', tab: 'layanan-detail', inputId: 'inputLayananKependudukan' }
];

// Initial setup to show the correct first widget and its search content
const initialDinas = dinasTabs[0].getAttribute('data-dinas');
dinasWidgets.forEach(widget => {
    widget.classList.toggle('hidden', widget.getAttribute('data-dinas') !== initialDinas);
});

dinasTabs.forEach(tab => {
    tab.addEventListener('click', () => {
        dinasTabs.forEach(t => t.classList.remove('tab-active'));
        tab.classList.add('tab-active');

        const dinas = tab.getAttribute('data-dinas');
        dinasWidgets.forEach(widget => {
            widget.classList.toggle('hidden', widget.getAttribute('data-dinas') !== dinas);
        });
        
        // Memuat konten pencarian default saat ganti tab
        const currentTabKey = inputMap.find(item => item.dinas === dinas)?.tab;
        if (currentTabKey) {
            handleSearch(dinas, currentTabKey);
        }
    });
});

// ==========================================================
// B. Inisialisasi Chart
// ==========================================================

// Chart Pendapatan (Line Chart) - DIUBAH MENJADI 3 BULAN
const ctxPendapatan = document.getElementById('chartPendapatan')?.getContext('2d');
if(ctxPendapatan){
    const data = @json($tren_pajak);
    const labels = data.map(item => item.label);
    const values = data.map(item => item.total / 1000000);
    new Chart(ctxPendapatan, {
        type:'line',
        data:{
            // Label diubah menjadi 3 bulan
            labels: labels,
            datasets:[{
                label:'Pendapatan (Juta)', 
                // Data diubah menjadi 3 bulan
                data: values, 
                borderColor:'white', 
                backgroundColor:'rgba(255,255,255,0.3)', 
                tension:0.4,
                pointRadius: 5,
                pointBackgroundColor: 'white'
            }]
        },
        options:{
            responsive:true, 
            maintainAspectRatio: false, 
            plugins:{ legend:{display:false} },
            scales: {
                x: { grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: 'white' } },
                y: { grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: 'white' } }
            }
        }
    });
}

// Chart Kesehatan (Doughnut Chart: Proporsi Tenaga Medis)
const tenagaMedisData = {
        dokter: {{ $statistik_faskes['dokter_tersedia'] ?? 0 }},
        perawat: {{ $statistik_faskes['perawat_tersedia'] ?? 0 }},
        bidan: {{ $statistik_faskes['bidan_tersedia'] ?? 0 }}
    };
const ctxKesehatan = document.getElementById('chartKesehatan')?.getContext('2d');
if(ctxKesehatan){
    new Chart(ctxKesehatan,{
        type:'doughnut',
        data:{
            labels:['Dokter','Perawat','Bidan'],
            datasets:[{
                label:'Jumlah Staf', 
                data:[tenagaMedisData.dokter,
                tenagaMedisData.perawat,
                tenagaMedisData.bidan
                ], 
                backgroundColor:['#4F46E5','#059669','#F59E0B'], 
                hoverOffset: 4
            }]
        },
        options:{
            responsive:true, 
            maintainAspectRatio: false,
            plugins:{ 
                legend:{
                    position: 'bottom',
                    labels: {
                        color: '#1F2937' 
                    }
                },
                title: {
                    display: true,
                    text: 'Distribusi Tenaga Medis Total',
                    color: '#1F2937'
                }
            }
        }
    });
}

// Chart Pekerjaan Umum (Bar Chart: Status Proyek)
const statistikPU = {
    aktif: {{ $statistik_pu['total_aktif'] ?? 0 }},
    selesai: {{ $statistik_pu['total_selesai'] ?? 0 }},
    terlambat: {{ $statistik_pu['total_terlambat'] ?? 0 }}
};
const ctxProyek = document.getElementById('chartProyek')?.getContext('2d');
if(ctxProyek){
    new Chart(ctxProyek,{
        type:'bar',
        data:{
            labels:['Aktif','Selesai','Terlambat'],
            datasets:[{
                label:'Jumlah Proyek', 
                data:[statistikPU.aktif,
                statistikPU.selesai,
                statistikPU.terlambat
                ], 
                backgroundColor:['#8B5CF6','#EC4899','#EF4444'], 
                borderWidth: 1
            }]
        },
        options:{
            responsive:true, 
            maintainAspectRatio: false,
            plugins:{ 
                legend:{
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Jumlah Proyek Berdasarkan Status',
                    color: '#1F2937'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Chart Kependudukan (Bar Chart: 5 Layanan Terbanyak Diajukan)
const ctxLayananKependudukan = document.getElementById('chartLayananKependudukan')?.getContext('2d');
if(ctxLayananKependudukan){
    const data = @json($lp_disduk);
    const labels = data.map(item => item.namaLayanan);
    const values = data.map(item => item.jumlah);
    new Chart(ctxLayananKependudukan,{
        type:'bar',
        data:{
            labels:['KK Baru','KTP Baru','Akta Lahir','Pindah Domisili','Akta Kematian'],
            datasets:[{
                label:'Jumlah Pengajuan', 
                data:values, 
                backgroundColor:['#3B82F6','#10B981','#F59E0B','#4F46E5','#EF4444'], 
                borderWidth: 1
            }]
        },
        options:{
            responsive:true, 
            maintainAspectRatio: false,
            plugins:{ 
                legend:{
                    display: false,
                },
                title: {
                    display: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}


// ==========================================================
// C. Tabs Pencarian Terintegrasi (Per Dinas)
// ==========================================================

// Memastikan pencarian dimuat saat pertama kali halaman dibuka (default tab 'pendapatan')
handleSearch('pendapatan', 'pajak'); 

// Fungsi handleSearch sudah diintegrasikan dengan tombol "Cari" di masing-masing dinas.
</script>

</body>
</html>