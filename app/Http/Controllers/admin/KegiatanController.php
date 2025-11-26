<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kegiatans = Kegiatan::orderBy('nama', 'asc')->get();
        return view('admin.kegiatan.index', compact('kegiatans'));
    }

    /**
     * Get data for DataTables
     */
    public function data()
    {
        $kegiatans = Kegiatan::orderBy('nama', 'asc')->get();

        $data = $kegiatans->map(function ($kegiatan) {
            return [
                'id' => $kegiatan->id,
                'nama' => $kegiatan->nama,
                'created_at' => $kegiatan->created_at->format('d M Y'),
            ];
        });

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kegiatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100|unique:kegiatan,nama',
        ], [
            'nama.required' => 'Nama kegiatan wajib diisi',
            'nama.max' => 'Nama kegiatan maksimal 100 karakter',
            'nama.unique' => 'Nama kegiatan sudah ada',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Kegiatan::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Data kegiatan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kegiatan $kegiatan)
    {
        // Redirect ke index dengan flag edit untuk membuka modal
        return redirect()->route('admin.kegiatan.index')
            ->with('editKegiatan', $kegiatan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100|unique:kegiatan,nama,' . $kegiatan->id,
        ], [
            'nama.required' => 'Nama kegiatan wajib diisi',
            'nama.max' => 'Nama kegiatan maksimal 100 karakter',
            'nama.unique' => 'Nama kegiatan sudah ada',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kegiatan->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Data kegiatan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Data kegiatan berhasil dihapus');
    }
}
