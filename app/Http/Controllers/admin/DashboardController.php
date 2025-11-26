<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TracerAlumni;
use App\Models\Perusahaan;
use App\Models\User;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Hitung data untuk dashboard
        $totalTracerAlumni = TracerAlumni::count();
        $totalPerusahaan = Perusahaan::count();
        $totalPelamar = User::whereIn('role', ['pelamar_alumni', 'pelamar_umum'])->count();
        $totalLowongan = Lowongan::count();

        // Get filter angkatan dari request
        $angkatanId = $request->get('angkatan_id');

        // Ambil semua kegiatan yang ada
        $semuaKegiatan = \App\Models\Kegiatan::orderBy('nama', 'asc')->get();

        // Query tracer alumni berdasarkan kegiatan
        $query = TracerAlumni::query();

        if ($angkatanId) {
            $query->where('angkatan_id', $angkatanId);
        }

        // Hitung alumni per kegiatan
        $alumniPerKegiatan = $query->selectRaw('kegiatan_id, COUNT(*) as total')
            ->groupBy('kegiatan_id')
            ->pluck('total', 'kegiatan_id');

        // Buat statistik dengan semua kegiatan (termasuk yang 0)
        $statistikKegiatan = [];
        foreach ($semuaKegiatan as $kegiatan) {
            $jumlah = $alumniPerKegiatan->get($kegiatan->id, 0);
            $statistikKegiatan[$kegiatan->nama] = $jumlah;
        }

        // Tambahkan alumni yang belum memilih kegiatan (jika ada)
        $belumMemilih = $alumniPerKegiatan->get(null, 0);
        if ($belumMemilih > 0) {
            $statistikKegiatan['Belum Memilih'] = $belumMemilih;
        }

        // Get semua angkatan untuk filter
        $angkatans = \App\Models\Angkatan::orderBy('tahun', 'desc')->get();

        return view('admin.dashboard', compact(
            'totalTracerAlumni',
            'totalPerusahaan',
            'totalPelamar',
            'totalLowongan',
            'statistikKegiatan',
            'angkatans',
            'angkatanId'
        ));
    }
}
