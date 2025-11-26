<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanPublicController extends Controller
{
    public function index()
    {
        // Ambil semua perusahaan yang aktif
        $perusahaans = Perusahaan::orderBy('nama_perusahaan', 'asc')
            ->paginate(12);

        return view('perusahaan.index', compact('perusahaans'));
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::with(['lowongan' => function ($query) {
            $query->where('status', 'aktif')->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('perusahaan.show', compact('perusahaan'));
    }
}
