<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LamaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lamarans = Lamaran::with(['user', 'lowongan.perusahaan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.lamaran.index', compact('lamarans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lamaran $lamaran)
    {
        $lamaran->load(['user', 'lowongan.perusahaan']);
        return view('admin.lamaran.edit', compact('lamaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lamaran $lamaran)
    {
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

        return redirect()->route('admin.lamaran.index')->with('success', 'Data lamaran berhasil diperbarui');
    }

    /**
     * Show detail lowongan
     */
    public function showLowongan(Lamaran $lamaran)
    {
        $lowongan = $lamaran->lowongan;
        $lowongan->load('perusahaan');
        return view('admin.lowongan.show', compact('lowongan'));
    }
}
