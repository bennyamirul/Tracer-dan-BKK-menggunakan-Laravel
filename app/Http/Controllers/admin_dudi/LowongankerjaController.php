<?php

namespace App\Http\Controllers\admin_dudi;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LowongankerjaController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        // Ambil perusahaan milik user login
        $perusahaans = Perusahaan::where('user_id', $user_id)
            ->orderBy('nama_perusahaan', 'asc')
            ->get();

        // Tampilkan lowongan yang perusahaan_id-nya termasuk milik user login
        $lowongans = Lowongan::with(['perusahaan'])
            ->whereIn('perusahaan_id', $perusahaans->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->get();
        // Beberapa bagian view menggunakan variabel $lowongan juga
        $lowongan = $lowongans;

        return view('admin_dudi.lowongan.index', compact('lowongans', 'lowongan', 'perusahaans'));
    }

    public function data()
    {
        $user_id = Auth::id();
        $perusahaanIds = Perusahaan::where('user_id', $user_id)->pluck('id');
        $lowongans = Lowongan::with(['perusahaan'])
            ->whereIn('perusahaan_id', $perusahaanIds)
            ->orderBy('created_at', 'desc')
            ->get();
        $data = $lowongans->map(function ($row) {
            return [
                'id' => $row->id,
                'perusahaan' => optional($row->perusahaan)->nama_perusahaan,
                'judul' => $row->judul,
                'posisi' => $row->posisi,
                'pendidikan_min' => $row->pendidikan_min,
                'pendidikan_jurusan' => $row->pendidikan_jurusan,
                'tanggal_dibuat' => optional($row->tanggal_dibuat)->format('Y-m-d'),
                'batas_lamaran' => optional($row->batas_lamaran)->format('Y-m-d'),
                'status' => $row->status,
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // perusahaan_id harus ada dan dimiliki oleh user login
            'perusahaan_id' => [
                'required',
                \Illuminate\Validation\Rule::exists('perusahaan', 'id')->where(function ($q) {
                    $q->where('user_id', Auth::id());
                }),
            ],
            'judul' => 'required|string|max:150',
            'posisi' => 'required|string|max:150',
            'pendidikan_min' => 'required|in:SD,SMP,SMA/SMK,D3,S1,S2,S3',
            'pendidikan_jurusan' => 'nullable|string|max:150',
            'batas_lamaran' => 'nullable|date',
            'deskripsi' => 'nullable|string',
        ]);
        $user_id = Auth::id();

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Lowongan::create([
            'perusahaan_id' => $request->perusahaan_id,
            'user_id' => $user_id,
            'judul' => $request->judul,
            'posisi' => $request->posisi,
            'pendidikan_min' => $request->pendidikan_min,
            'pendidikan_jurusan' => $request->pendidikan_jurusan,
            'tanggal_dibuat' => now(),
            'batas_lamaran' => $request->batas_lamaran,
            'deskripsi' => $request->deskripsi,
            'status' => 'aktif',
        ]);

        return redirect()->route('admin_dudi.lowongan.index')->with('success', 'Lowongan kerja berhasil ditambahkan');
    }

    public function show(Lowongan $lowongan)
    {
        // Eager load perusahaan
        $lowongan->load('perusahaan');

        // Pastikan lowongan adalah milik perusahaan user login
        $user_id = Auth::id();
        $isOwned = Perusahaan::where('user_id', $user_id)
            ->where('id', $lowongan->perusahaan_id)
            ->exists();
        abort_if(!$isOwned, 403, 'Anda tidak memiliki akses ke lowongan ini');

        return view('admin_dudi.lowongan.show', compact('lowongan'));
    }

    public function update(Request $request, Lowongan $lowongan)
    {
        // Pastikan lowongan yang diupdate adalah milik perusahaan user login
        $user_id = Auth::id();
        $isOwned = Perusahaan::where('user_id', $user_id)
            ->where('id', $lowongan->perusahaan_id)
            ->exists();
        abort_if(!$isOwned, 403);

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:150',
            'posisi' => 'required|string|max:150',
            'pendidikan_min' => 'required|in:SD,SMP,SMA/SMK,D3,S1,S2,S3',
            'pendidikan_jurusan' => 'nullable|string|max:150',
            'batas_lamaran' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $lowongan->update([
            'judul' => $request->judul,
            'posisi' => $request->posisi,
            'pendidikan_min' => $request->pendidikan_min,
            'pendidikan_jurusan' => $request->pendidikan_jurusan,
            'batas_lamaran' => $request->batas_lamaran,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        return redirect()->route('admin_dudi.lowongan.index')->with('success', 'Lowongan kerja berhasil diperbarui');
    }

    public function destroy(Lowongan $lowongan)
    {
        // Pastikan lowongan yang dihapus adalah milik perusahaan user login
        $user_id = Auth::id();
        $isOwned = Perusahaan::where('user_id', $user_id)
            ->where('id', $lowongan->perusahaan_id)
            ->exists();
        abort_if(!$isOwned, 403);

        $lowongan->delete();
        return redirect()->route('admin_dudi.lowongan.index')->with('success', 'Lowongan kerja berhasil dihapus');
    }
}
