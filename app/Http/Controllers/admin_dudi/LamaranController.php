<?php

namespace App\Http\Controllers\admin_dudi;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LamaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();

        // Ambil perusahaan milik user login
        $perusahaanIds = Perusahaan::where('user_id', $user_id)->pluck('id');

        // Tampilkan lamaran yang lowongannya milik perusahaan user login
        $lamarans = Lamaran::with(['user', 'lowongan.perusahaan'])
            ->whereHas('lowongan', function ($query) use ($perusahaanIds) {
                $query->whereIn('perusahaan_id', $perusahaanIds);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin_dudi.lamaran.index', compact('lamarans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lamaran $lamaran)
    {
        // Pastikan lamaran adalah milik lowongan dari perusahaan user login
        $user_id = Auth::id();
        $isOwned = Perusahaan::where('user_id', $user_id)
            ->where('id', $lamaran->lowongan->perusahaan_id)
            ->exists();
        abort_if(!$isOwned, 403, 'Anda tidak memiliki akses ke lamaran ini');

        $lamaran->load(['user', 'lowongan.perusahaan']);
        return view('admin_dudi.lamaran.edit', compact('lamaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lamaran $lamaran)
    {
        // Pastikan lamaran adalah milik lowongan dari perusahaan user login
        $user_id = Auth::id();
        $isOwned = Perusahaan::where('user_id', $user_id)
            ->where('id', $lamaran->lowongan->perusahaan_id)
            ->exists();
        abort_if(!$isOwned, 403, 'Anda tidak memiliki akses ke lamaran ini');

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:diajukan,diproses,wawancara,diterima,ditolak',
            'tanggal_wawancara' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $lamaran->update([
            'status' => $request->status,
            'tanggal_wawancara' => $request->tanggal_wawancara,
        ]);

        return redirect()->route('admin_dudi.lamaran.index')->with('success', 'Data lamaran berhasil diperbarui');
    }

    /**
     * Show detail lowongan
     */
    public function showLowongan(Lamaran $lamaran)
    {
        // Pastikan lamaran adalah milik lowongan dari perusahaan user login
        $user_id = Auth::id();
        $isOwned = Perusahaan::where('user_id', $user_id)
            ->where('id', $lamaran->lowongan->perusahaan_id)
            ->exists();
        abort_if(!$isOwned, 403, 'Anda tidak memiliki akses ke lamaran ini');

        $lowongan = $lamaran->lowongan;
        $lowongan->load('perusahaan');
        return view('admin_dudi.lowongan.show', compact('lowongan'));
    }
}
