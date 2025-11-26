<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\User;
use App\Models\Berkas;
use App\Models\TracerAlumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LowonganPublicController extends Controller
{
    public function index()
    {
        // Ambil semua lowongan yang aktif dengan pagination
        $lowongans = Lowongan::with(['perusahaan'])
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('lowongan.index', compact('lowongans'));
    }

    public function show($id)
    {
        $lowongan = Lowongan::with(['perusahaan'])->findOrFail($id);

        // Cek apakah user sudah melamar
        $hasApplied = false;
        $hasBerkas = false;
        $missingData = [];
        if (Auth::check()) {
            $hasApplied = Lamaran::where('user_id', Auth::id())
                ->where('lowongan_id', $id)
                ->exists();

            $user = Auth::user();
            $hasUserData = !empty($user->nama) && !empty($user->email) && !empty($user->no_telp) && !empty($user->tanggal_lahir);
            if (!$hasUserData) {
                $missingData[] = 'Data Diri';
            }
            $hasTracer = TracerAlumni::where('user_id', Auth::id())->exists();
            if (!$hasTracer) {
                $missingData[] = 'Data Tracer Alumni';
            }

            // Cek apakah user sudah upload berkas (CV dan Surat Lamaran)
            $hasCV = Berkas::where('user_id', Auth::id())->where('jenis', 'CV')->exists();
            $hasSuratLamaran = Berkas::where('user_id', Auth::id())->where('jenis', 'Surat Lamaran')->exists();
            $hasBerkas = $hasCV && $hasSuratLamaran;
            if (!$hasBerkas) {
                $missingData[] = 'Berkas';
            }
            $isComplete = $hasUserData && $hasTracer && $hasBerkas;

            $isComplete = empty($missingData);
        }

        return view('lowongan.show', compact('lowongan', 'hasApplied', 'isComplete', 'missingData'));
    }

    public function apply(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $lowongan = Lowongan::findOrFail($id);

        // Cek apakah sudah melamar
        $existingLamaran = Lamaran::where('user_id', Auth::id())
            ->where('lowongan_id', $id)
            ->first();

        if ($existingLamaran) {
            return redirect()->back()->with('error', 'Anda sudah melamar lowongan ini');
        }

        // Cek apakah user sudah upload berkas (CV dan Surat Lamaran)
        $user = Auth::user();
        $hasCV = Berkas::where('user_id', Auth::id())->where('jenis', 'CV')->exists();
        $hasSuratLamaran = Berkas::where('user_id', Auth::id())->where('jenis', 'Surat Lamaran')->exists();

        if (!$hasCV || !$hasSuratLamaran) {
            $missingDocs = [];
            if (!$hasCV) $missingDocs[] = 'CV';
            if (!$hasSuratLamaran) $missingDocs[] = 'Surat Lamaran';

            return redirect()->back()->with('error', 'Anda harus mengupload ' . implode(' dan ', $missingDocs) . ' terlebih dahulu di halaman profil');
        }

        // Buat lamaran baru
        Lamaran::create([
            'user_id' => Auth::id(),
            'lowongan_id' => $id,
            'status' => 'diajukan',
            'tanggal_lamaran' => now(),
        ]);

        return redirect()->back()->with('success', 'Lamaran berhasil dikirim!');
    }
}
