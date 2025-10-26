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
            
            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-blue-500 hover:shadow-2xl transition duration-300">
                <p class="text-sm font-medium text-blue-600 uppercase mb-2">Total Pendapatan Pajak</p>
                <p class="text-4xl font-bold text-gray-900">Rp 125,5 Jt</p>
                <p class="text-xs text-gray-500 mt-2">Target 75% Tercapai</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-teal-500 hover:shadow-2xl transition duration-300">
                <p class="text-sm font-medium text-teal-600 uppercase mb-2">Wajib Pajak Terdaftar</p>
                <p class="text-4xl font-bold text-gray-900">12.500</p>
                <p class="text-xs text-gray-500 mt-2">Data Entitas Wajib Pajak</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-green-500 hover:shadow-2xl transition duration-300">
                <p class="text-sm font-medium text-green-600 uppercase mb-2">Jenis Pajak Terbanyak</p>
                <p class="text-2xl font-bold text-gray-900">PBB dan Reklame</p>
                <p class="text-xs text-gray-500 mt-2">Berdasarkan Jumlah Transaksi</p>
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
                <p class="text-4xl font-bold text-gray-900">14</p>
                <p class="text-xs text-gray-500 mt-2">Total Proyek yang sedang berjalan</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-pink-500 hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-pink-600 uppercase mb-2">Proyek Selesai (Jumlah)</h2>
                <p class="text-4xl font-bold text-gray-900">58</p>
                <p class="text-xs text-gray-500 mt-2">Total Proyek yang sudah selesai</p>
             </div>
             <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-red-500 hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-red-600 uppercase mb-2">Proyek Terlambat (Jumlah)</h2>
                <p class="text-4xl font-bold text-gray-900">3</p>
                <p class="text-xs text-gray-500 mt-2">Perlu penanganan segera</p>
            </div>
            <div class="bg-purple-800 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-purple-200 uppercase mb-2">SEKTOR PROYEK TERBANYAK</h2>
                <p class="text-2xl font-bold">Infrastruktur Jalan</p>
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
                <p class="text-4xl font-bold text-gray-900">30</p>
                <p class="text-xs text-gray-500 mt-2">Data Tenaga Medis</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-green-500 hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-green-600 uppercase mb-2">Perawat Tersedia</h2>
                <p class="text-4xl font-bold text-gray-900">70</p>
                <p class="text-xs text-gray-500 mt-2">Data Tenaga Medis</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-yellow-500 hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-yellow-600 uppercase mb-2">Bidan Tersedia</h2>
                <p class="text-4xl font-bold text-gray-900">20</p>
                <p class="text-xs text-gray-500 mt-2">Data Tenaga Medis</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-red-500 hover:shadow-2xl transition duration-300">
                <h2 class="text-sm font-medium text-red-600 uppercase mb-2">Faskes Terdaftar</h2>
                <p class="text-4xl font-bold text-gray-900">35</p>
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

            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-blue-500 hover:shadow-2xl transition duration-300">
                <h2 class="font-semibold mb-2 text-sm text-blue-600 uppercase">Total Layanan Masuk (Bulan Ini)</h2>
                <p class="text-4xl font-bold text-gray-900">4.520</p>
                <p class="text-xs text-gray-500 mt-2">Dihitung dari Entitas Layanan</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-red-500 hover:shadow-2xl transition duration-300">
                <h2 class="font-semibold mb-2 text-sm text-red-600 uppercase">Persentase Layanan Tertunda</h2>
                <p class="text-4xl font-bold text-gray-900">15%</p>
                <p class="text-xs text-gray-500 mt-2">Karena kekurangan persyaratan</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-purple-500 hover:shadow-2xl transition duration-300">
                <h2 class="font-semibold mb-2 text-sm text-purple-600 uppercase">Layanan Selesai</h2>
                <p class="text-4xl font-bold text-gray-900">3.800</p>
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
    
    if (contentElement) {
        contentElement.innerHTML = createContentHtml(targetTabName);
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
    new Chart(ctxPendapatan, {
        type:'line',
        data:{
            // Label diubah menjadi 3 bulan
            labels:['Agu','Sep','Okt'],
            datasets:[{
                label:'Pendapatan (Milyar)', 
                // Data diubah menjadi 3 bulan
                data:[1.9, 2.0, 2.3], 
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
const ctxKesehatan = document.getElementById('chartKesehatan')?.getContext('2d');
if(ctxKesehatan){
    new Chart(ctxKesehatan,{
        type:'doughnut',
        data:{
            labels:['Dokter','Perawat','Bidan'],
            datasets:[{
                label:'Jumlah Staf', 
                data:[30, 70, 20], 
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
const ctxProyek = document.getElementById('chartProyek')?.getContext('2d');
if(ctxProyek){
    new Chart(ctxProyek,{
        type:'bar',
        data:{
            labels:['Aktif','Selesai','Terlambat'],
            datasets:[{
                label:'Jumlah Proyek', 
                data:[14, 58, 3], 
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
    new Chart(ctxLayananKependudukan,{
        type:'bar',
        data:{
            labels:['KK Baru','KTP Baru','Akta Lahir','Pindah Domisili','Akta Kematian'],
            datasets:[{
                label:'Jumlah Pengajuan', 
                data:[1500, 1200, 850, 500, 470], 
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