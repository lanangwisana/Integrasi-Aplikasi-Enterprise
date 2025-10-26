<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $statistik_faskes = Http::get(config('esb.dinkes.base_uri') . '/faskes/statistik');
        $statistik_faskes = $statistik_faskes->json();

        $statistik_pu = Http::get(config('esb.dinpu.base_uri'));
        $data_pu = $statistik_pu->json();
        $statistik_pu = $data_pu['statistik'] ?? [];

        $statistik_dinduk = Http::get(config('esb.dinduk.base_uri') . '/statistik');
        $statistik_dinduk = $statistik_dinduk->json();
        $statistik_dinduk = $statistik_dinduk ?? [];
        $lp_disduk = Http::get(config('esb.dinduk.base_uri') . '/layanan-populer');
        $lp_disduk = $lp_disduk->json();
        $lp_disduk = $lp_disduk ?? [];

        return view('admin.dashboard', compact('statistik_faskes', 'statistik_pu', 'statistik_dinduk', 'lp_disduk'));
    }
    public function cariFaskes(Request $request)
    {
        $nama = strtolower(trim($request->query('nama')));
        $response = Http::get(config('esb.dinkes.base_uri') . "/faskes");
        $data = $response->json();

        // Filter manual berdasarkan nama
        $filtered = collect($data)->first(function ($item) use ($nama) {
            return strtolower($item['nama_faskes'] ?? '') === $nama;
        });

        return response()->json($filtered ?? []);
    }

    public function cariProyek(Request $request)
    {
        $nama = strtolower(trim($request->query('id')));
        $response = Http::get(config('esb.dinpu.base_uri'));
        $data = $response->json();

        // Filter manual berdasarkan id
        $filtered = collect($data['proyek'] ?? [])->first(function ($item) use ($nama) {
            return strtolower($item['id'] ?? '') === $nama;
        });

        return response()->json($filtered ?? []);
    }

    public function cariPenduduk(Request $request)
    {
        $id = strtolower(trim($request->query('id')));
        $response = Http::get(config('esb.dinduk.base_uri') . '/status');
        $data = $response->json();

        $filtered = collect($data ?? [])->first(function ($item) use ($id) {
            return strtolower($item['iD_Pengajuan'] ?? '') === $id;
        });

        return response()->json($filtered ?? []);
    }

}
