<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusans = Jurusan::orderBy('kode', 'asc')->get();
        return view('admin.jurusan.index', compact('jurusans'));
    }

    /**
     * Get data for DataTables
     */
    public function data()
    {
        $jurusans = Jurusan::orderBy('kode', 'asc')->get();

        $data = $jurusans->map(function ($jurusan) {
            return [
                'id' => $jurusan->id,
                'kode' => $jurusan->kode,
                'nama' => $jurusan->nama,
                'created_at' => $jurusan->created_at->format('d M Y'),
            ];
        });

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Display simple version (no custom JS)
     */
    public function indexSimple()
    {
        $jurusans = Jurusan::orderBy('kode', 'asc')->get();
        return view('admin.jurusan.simple', compact('jurusans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jurusan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string|max:16|unique:jurusan,kode',
            'nama' => 'required|string|max:100|unique:jurusan,nama',
        ], [
            'kode.required' => 'Kode jurusan wajib diisi',
            'kode.unique' => 'Kode jurusan sudah ada',
            'kode.max' => 'Kode jurusan maksimal 16 karakter',
            'nama.required' => 'Nama jurusan wajib diisi',
            'nama.unique' => 'Nama jurusan sudah ada',
            'nama.max' => 'Nama jurusan maksimal 100 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Jurusan::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data jurusan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurusan $jurusan)
    {
        return view('admin.jurusan.show', compact('jurusan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        // Redirect ke index dengan flag edit untuk membuka modal
        return redirect()->route('admin.jurusan.index')
            ->with('editJurusan', $jurusan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string|max:16|unique:jurusan,kode,' . $jurusan->id,
            'nama' => 'required|string|max:100|unique:jurusan,nama,' . $jurusan->id,
        ], [
            'kode.required' => 'Kode jurusan wajib diisi',
            'kode.unique' => 'Kode jurusan sudah ada',
            'kode.max' => 'Kode jurusan maksimal 16 karakter',
            'nama.required' => 'Nama jurusan wajib diisi',
            'nama.unique' => 'Nama jurusan sudah ada',
            'nama.max' => 'Nama jurusan maksimal 100 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $jurusan->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data jurusan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data jurusan berhasil dihapus');
    }
}
