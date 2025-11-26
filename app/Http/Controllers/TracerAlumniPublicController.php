<?php

namespace App\Http\Controllers;

use App\Models\TracerAlumni;
use App\Models\Angkatan;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class TracerAlumniPublicController extends Controller
{
    public function index(Request $request)
    {
        $angkatanId = $request->get('angkatan_id');

        // Query tracers dengan optional filter angkatan
        $tracersQuery = TracerAlumni::with(['user', 'jurusan', 'angkatan', 'kegiatan'])
            ->whereHas('user')
            ->orderBy('created_at', 'desc');

        if ($angkatanId) {
            $tracersQuery->where('angkatan_id', $angkatanId);
        }

        $tracers = $tracersQuery->get();

        // Data untuk dropdown
        $angkatans = Angkatan::orderBy('tahun', 'desc')->get();

        // Ambil semua kegiatan yang ada
        $semuaKegiatan = Kegiatan::orderBy('nama', 'asc')->get();

        // Query tracer alumni berdasarkan kegiatan
        $queryStatistik = TracerAlumni::query();

        if ($angkatanId) {
            $queryStatistik->where('angkatan_id', $angkatanId);
        }

        // Hitung alumni per kegiatan
        $alumniPerKegiatan = $queryStatistik->selectRaw('kegiatan_id, COUNT(*) as total')
            ->groupBy('kegiatan_id')
            ->pluck('total', 'kegiatan_id');

        // Buat statistik dengan semua kegiatan (termasuk yang 0)
        $statistikKegiatan = [];
        foreach ($semuaKegiatan as $kegiatan) {
            $jumlah = $alumniPerKegiatan->get($kegiatan->id, 0);
            $statistikKegiatan[$kegiatan->nama] = $jumlah;
        }

        // Total tracer alumni
        $totalTracerAlumni = $tracers->count();

        return view('tracer-alumni.index', compact(
            'tracers',
            'angkatans',
            'statistikKegiatan',
            'totalTracerAlumni',
            'angkatanId'
        ));
    }
}
