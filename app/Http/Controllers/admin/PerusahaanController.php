<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaans = Perusahaan::orderBy('created_at', 'desc')->get();
        return view('admin.perusahaan.index', compact('perusahaans'));
    }

    public function data()
    {
        $perusahaans = Perusahaan::orderBy('created_at', 'desc')->get();

        $data = $perusahaans->map(function ($perusahaan) {
            return [
                'id' => $perusahaan->id,
                'nama_perusahaan' => $perusahaan->nama_perusahaan,
                'logo' => $perusahaan->logo,
                'email' => $perusahaan->email,
                'kontak' => $perusahaan->kontak,
                'alamat' => $perusahaan->alamat,
                'created_at' => optional($perusahaan->created_at)->format('d M Y'),
            ];
        });

        return response()->json([
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_perusahaan' => 'required|string|max:150|unique:perusahaan,nama_perusahaan',
            'email' => 'nullable|email|max:191',
            'kontak' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_perusahaan.required' => 'Nama perusahaan wajib diisi',
            'nama_perusahaan.unique' => 'Nama perusahaan sudah ada',
            'email.email' => 'Email tidak valid',
            'logo.image' => 'Logo harus berupa gambar',
            'logo.mimes' => 'Format logo harus jpg, jpeg, png, svg, atau webp',
            'logo.max' => 'Ukuran logo maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('perusahaan', 'public');
        }

        Perusahaan::create([
            'nama_perusahaan' => $request->nama_perusahaan,
            'logo' => $logoPath,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'email' => $request->email,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.perusahaan.index')
            ->with('success', 'Data perusahaan berhasil ditambahkan');
    }

    public function show(Perusahaan $perusahaan)
    {
        return view('admin.perusahaan.show', compact('perusahaan'));
    }

    public function edit(Perusahaan $perusahaan)
    {
        return redirect()->route('admin.perusahaan.index')
            ->with('editPerusahaan', $perusahaan);
    }

    public function destroy(Perusahaan $perusahaan)
    {
        $perusahaan->delete();
        return redirect()->route('admin.perusahaan.index')
            ->with('success', 'Data perusahaan berhasil dihapus');
    }

    public function update(Request $request, Perusahaan $perusahaan)
    {
        $validator = Validator::make($request->all(), [
            'nama_perusahaan' => 'required|string|max:150|unique:perusahaan,nama_perusahaan,' . $perusahaan->id,
            'email' => 'nullable|email|max:191',
            'kontak' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_perusahaan.required' => 'Nama perusahaan wajib diisi',
            'nama_perusahaan.unique' => 'Nama perusahaan sudah ada',
            'email.email' => 'Email tidak valid',
            'logo.image' => 'Logo harus berupa gambar',
            'logo.mimes' => 'Format logo harus jpg, jpeg, png, svg, atau webp',
            'logo.max' => 'Ukuran logo maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $logoPath = $perusahaan->logo;
        if ($request->hasFile('logo')) {
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('logo')->store('perusahaan', 'public');
        }

        $perusahaan->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'logo' => $logoPath,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'email' => $request->email,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.perusahaan.index')
            ->with('success', 'Data perusahaan berhasil diperbarui');
    }
}
