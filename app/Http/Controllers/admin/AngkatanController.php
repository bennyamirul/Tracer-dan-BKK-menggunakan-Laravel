<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AngkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $angkatans = Angkatan::orderBy('tahun', 'desc')->get();
        return view('admin.angkatan.index', compact('angkatans'));
    }

    /**
     * Get data for DataTables
     */
    public function data()
    {
        $angkatans = Angkatan::orderBy('tahun', 'desc')->get();

        $data = $angkatans->map(function ($angkatan) {
            return [
                'id' => $angkatan->id,
                'tahun' => $angkatan->tahun,
                'nama' => $angkatan->nama,
                'display_name' => $angkatan->display_name,
                'created_at' => $angkatan->created_at->format('d M Y'),
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
        return view('admin.angkatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|integer|min:2000|max:2100|unique:tahun_angkatan,tahun',
            'nama' => 'nullable|string|max:50',
        ], [
            'tahun.required' => 'Tahun angkatan wajib diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'tahun.min' => 'Tahun minimal 2000',
            'tahun.max' => 'Tahun maksimal 2100',
            'tahun.unique' => 'Tahun angkatan sudah ada',
            'nama.max' => 'Nama angkatan maksimal 50 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Angkatan::create([
            'tahun' => $request->tahun,
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.angkatan.index')
            ->with('success', 'Data angkatan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Angkatan $angkatan)
    {
        return view('admin.angkatan.show', compact('angkatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Angkatan $angkatan)
    {
        // Redirect ke index dengan flag edit untuk membuka modal
        return redirect()->route('admin.angkatan.index')
            ->with('editAngkatan', $angkatan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Angkatan $angkatan)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|integer|min:2000|max:2100|unique:tahun_angkatan,tahun,' . $angkatan->id,
            'nama' => 'nullable|string|max:50',
        ], [
            'tahun.required' => 'Tahun angkatan wajib diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'tahun.min' => 'Tahun minimal 2000',
            'tahun.max' => 'Tahun maksimal 2100',
            'tahun.unique' => 'Tahun angkatan sudah ada',
            'nama.max' => 'Nama angkatan maksimal 50 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $angkatan->update([
            'tahun' => $request->tahun,
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.angkatan.index')
            ->with('success', 'Data angkatan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Angkatan $angkatan)
    {
        $angkatan->delete();

        return redirect()->route('admin.angkatan.index')
            ->with('success', 'Data angkatan berhasil dihapus');
    }
}
