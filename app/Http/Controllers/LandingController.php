<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil lowongan kerja yang aktif (maksimal 6 untuk ditampilkan)
        $lowongans = Lowongan::with(['perusahaan'])
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Ambil perusahaan yang terdaftar (maksimal 6 untuk ditampilkan)
        $perusahaans = Perusahaan::orderBy('nama_perusahaan', 'asc')
            ->limit(6)
            ->get();

        // Hitung total pencari kerja (alumni)
        $users = User::whereIn('role', ['pelamar_alumni', 'pelamar_umum'])->get();

        return view('landing', compact('lowongans', 'perusahaans', 'users'));
    }
}
