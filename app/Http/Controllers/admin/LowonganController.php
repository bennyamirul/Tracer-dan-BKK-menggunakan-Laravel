<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LowonganController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $lowongans = Lowongan::with(['perusahaan'])->orderBy('created_at', 'desc')->get();
        // Beberapa bagian view menggunakan variabel $lowongan juga
        $lowongan = $lowongans;
        $perusahaans = Perusahaan::orderBy('created_at', 'desc')->get();

        return view('admin.lowongan.index', compact('lowongans', 'lowongan', 'perusahaans'));
    }

    public function data()
    {
        $lowongans = Lowongan::with(['perusahaan'])->orderBy('created_at', 'desc')->get();
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
            'perusahaan_id' => 'required|exists:perusahaan,id',
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

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan kerja berhasil ditambahkan');
    }

    public function show(Lowongan $lowongan)
    {
        $lowongan->load('perusahaan');
        return view('admin.lowongan.show', compact('lowongan'));
    }

    public function update(Request $request, Lowongan $lowongan)
    {
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

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan kerja berhasil diperbarui');
    }

    public function destroy(Lowongan $lowongan)
    {
        $lowongan->delete();
        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan kerja berhasil dihapus');
    }
}
