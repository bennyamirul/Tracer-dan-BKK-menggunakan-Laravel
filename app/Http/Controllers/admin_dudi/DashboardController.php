<?php

namespace App\Http\Controllers\admin_dudi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Perusahaan;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $perusahaan = optional($user)->dudi; // relasi user->dudi (Perusahaan)

        $companyId = optional($perusahaan)->id;

        // Siapkan data default jika belum ada perusahaan terkait
        if (!$companyId) {
            return view('admin_dudi.dashboard', [
                'perusahaan' => $perusahaan,
                'seriesLowonganBulanan' => [],
                'lowonganPerTahun' => [],
                'availableYears' => [Carbon::now()->year],
                'currentYear' => Carbon::now()->year,
                'labelsBulan' => [],
                'seriesLamaranTahun' => [],
                'seriesLamaranBulan' => [],
                'seriesLamaranMinggu' => [],
                'labelsTahun' => [],
                'labelsBulanHari' => [],
                'labelsMinggu' => [],
                'latestLamaran' => collect(),
            ]);
        }

        $now = Carbon::now();

        // Dapatkan tahun-tahun yang tersedia untuk filter (dari lowongan perusahaan)
        $availableYears = DB::table('lowongan_kerja')
            ->where('perusahaan_id', $companyId)
            ->selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Jika tidak ada data, tambahkan tahun sekarang
        if (empty($availableYears)) {
            $availableYears[] = $now->year;
        }

        // Chart Widget 1: Lowongan per bulan untuk semua tahun yang tersedia
        $lowonganPerTahun = [];
        $labelsBulan = [];

        foreach ($availableYears as $year) {
            $lowonganBulanan = DB::table('lowongan_kerja')
                ->where('perusahaan_id', $companyId)
                ->whereYear('created_at', $year)
                ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                ->groupBy('bulan')
                ->pluck('total', 'bulan');

            $seriesData = [];
            for ($m = 1; $m <= 12; $m++) {
                $seriesData[] = (int) ($lowonganBulanan[$m] ?? 0);
            }

            $lowonganPerTahun[$year] = $seriesData;
        }

        // Labels bulan (sama untuk semua tahun)
        for ($m = 1; $m <= 12; $m++) {
            $labelsBulan[] = Carbon::create()->month($m)->locale('id')->isoFormat('MMM');
        }

        // Data default untuk tahun sekarang
        $seriesLowonganBulanan = $lowonganPerTahun[$now->year] ?? array_fill(0, 12, 0);

        // Chart Widget 3 - Lamaran Per Bulan (dengan filter tahun seperti Chart Lowongan)
        // Ambil tahun-tahun yang tersedia dari lamaran
        $availableYearsLamaran = DB::table('lamaran')
            ->join('lowongan_kerja', 'lamaran.lowongan_id', '=', 'lowongan_kerja.id')
            ->where('lowongan_kerja.perusahaan_id', $companyId)
            ->selectRaw('DISTINCT YEAR(lamaran.tanggal_lamaran) as tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        // Jika tidak ada data lamaran, set tahun saat ini
        if (empty($availableYearsLamaran)) {
            $availableYearsLamaran = [$now->year];
        }

        // Ambil data lamaran per bulan untuk setiap tahun
        $lamaranPerTahun = [];
        foreach ($availableYearsLamaran as $year) {
            $lamaranBulanan = DB::table('lamaran')
                ->join('lowongan_kerja', 'lamaran.lowongan_id', '=', 'lowongan_kerja.id')
                ->where('lowongan_kerja.perusahaan_id', $companyId)
                ->whereYear('lamaran.tanggal_lamaran', $year)
                ->selectRaw('MONTH(lamaran.tanggal_lamaran) as bulan, COUNT(*) as total')
                ->groupBy('bulan')
                ->pluck('total', 'bulan');

            $seriesPerBulan = [];
            for ($m = 1; $m <= 12; $m++) {
                $seriesPerBulan[] = (int) ($lamaranBulanan[$m] ?? 0);
            }
            $lamaranPerTahun[$year] = $seriesPerBulan;
        }

        // Data lamaran untuk tahun berjalan (untuk initial render)
        $seriesLamaranBulanan = $lamaranPerTahun[$now->year] ?? array_fill(0, 12, 0);

        // Data lamaran terbaru untuk list
        $latestLamaran = DB::table('lamaran as lm')
            ->join('lowongan_kerja as lk', 'lm.lowongan_id', '=', 'lk.id')
            ->join('users as u', 'lm.user_id', '=', 'u.id')
            ->where('lk.perusahaan_id', $companyId)
            ->orderBy('lm.created_at', 'desc')
            ->limit(10)
            ->select('lm.id', 'lm.status', 'lm.tanggal_lamaran', 'u.nama as pelamar', 'lk.judul as lowongan')
            ->get();

        return view('admin_dudi.dashboard', [
            'perusahaan' => $perusahaan,
            // Chart Widget 1 - Data Lowongan
            'seriesLowonganBulanan' => $seriesLowonganBulanan,
            'lowonganPerTahun' => $lowonganPerTahun,
            'availableYears' => $availableYears,
            'currentYear' => $now->year,
            'labelsBulan' => $labelsBulan,
            // Chart Widget 3 - Data Lamaran
            'seriesLamaranBulanan' => $seriesLamaranBulanan,
            'lamaranPerTahun' => $lamaranPerTahun,
            'availableYearsLamaran' => $availableYearsLamaran,
            'latestLamaran' => $latestLamaran,
        ]);
    }

    /**
     * Update data perusahaan
     */
    public function update(Request $request, Perusahaan $perusahaan)
    {
        // Validasi bahwa user yang login adalah pemilik perusahaan ini
        $user = Auth::user();
        if ($perusahaan->user_id !== $user->id) {
            return redirect()->route('admin_dudi.dashboard')
                ->with('error', 'Anda tidak memiliki akses untuk mengubah data perusahaan ini.');
        }

        // Validasi input
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:150|min:2',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama_perusahaan.required' => 'Nama perusahaan harus diisi',
            'nama_perusahaan.min' => 'Nama perusahaan minimal 2 karakter',
            'nama_perusahaan.max' => 'Nama perusahaan maksimal 150 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'no_telp.required' => 'No. Telepon harus diisi',
            'logo.image' => 'File harus berupa gambar',
            'logo.mimes' => 'Logo harus berformat jpeg, png, jpg, atau gif',
            'logo.max' => 'Ukuran logo maksimal 2MB',
        ]);

        try {
            // Handle upload logo jika ada
            if ($request->hasFile('logo')) {
                // Hapus logo lama jika ada
                if ($perusahaan->logo && Storage::disk('public')->exists($perusahaan->logo)) {
                    Storage::disk('public')->delete($perusahaan->logo);
                }

                // Upload logo baru
                $logoPath = $request->file('logo')->store('logos', 'public');
                $validated['logo'] = $logoPath;
            }

            // Update data perusahaan
            // Note: field 'kontak' di database, tapi 'no_telp' di form
            $perusahaan->update([
                'nama_perusahaan' => $validated['nama_perusahaan'],
                'email' => $validated['email'],
                'kontak' => $validated['no_telp'], // mapping no_telp ke kontak
                'alamat' => $validated['alamat'] ?? $perusahaan->alamat,
                'deskripsi' => $validated['deskripsi'] ?? $perusahaan->deskripsi,
                'logo' => $validated['logo'] ?? $perusahaan->logo,
            ]);

            return redirect()->route('admin_dudi.dashboard')
                ->with('success', 'Data perusahaan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin_dudi.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
