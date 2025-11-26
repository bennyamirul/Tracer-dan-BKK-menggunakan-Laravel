<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lamaran;
use App\Models\Berkas;
use App\Models\TracerAlumni;
use App\Models\Jurusan;
use App\Models\Angkatan;
use App\Models\Kegiatan;

class ProfileUserController extends Controller
{
    public function show(int $userId)
    {
        $user = User::findOrFail($userId);
        $berkas = Berkas::where('user_id', $user->id)->latest()->get();
        $lamarans = Lamaran::with('lowongan')->where('user_id', $user->id)->latest()->get();
        $tracer = TracerAlumni::with(['jurusan', 'angkatan', 'kegiatan'])->where('user_id', $user->id)->first();

        return view('admin.profile-user.index', compact('user', 'berkas', 'lamarans', 'tracer'));
    }

    public function edit(int $userId)
    {
        $user = User::findOrFail($userId);
        $tracer = TracerAlumni::where('user_id', $user->id)->first();
        $berkas = Berkas::where('user_id', $user->id)->latest()->get();
        $jurusans = Jurusan::orderBy('nama')->get();
        $angkatans = Angkatan::orderBy('tahun', 'desc')->get();
        $kegiatans = Kegiatan::orderBy('nama')->get();

        return view('admin.profile-user.edit', compact('user', 'tracer', 'berkas', 'jurusans', 'angkatans', 'kegiatans'));
    }

    public function update(\Illuminate\Http\Request $request, int $userId)
    {
        $user = User::findOrFail($userId);
        $section = $request->input('section', 'user');

        // Upload Berkas (CV atau Surat Lamaran)
        if ($section === 'berkas') {
            $validated = $request->validate([
                'jenis' => ['required', 'in:CV,Surat Lamaran'],
                'file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // max 5MB
            ]);

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('berkas', $fileName, 'public');

            Berkas::create([
                'user_id' => $user->id,
                'jenis' => $validated['jenis'],
                'file_path' => $path,
            ]);

            return redirect()->route('admin.profile-user.edit', $userId)
                ->with('status', 'Berkas berhasil diunggah')
                ->with('activeTab', 'berkas');
        }

        // Update Tracer Alumni
        if ($section === 'tracer') {
            $validated = $request->validate([
                'tracer.jurusan_id' => ['required', 'exists:jurusan,id'],
                'tracer.angkatan_id' => ['required', 'exists:tahun_angkatan,id'],
                'tracer.kegiatan_id' => ['required', 'exists:kegiatan,id'],
                'tracer.posisi_peran' => ['nullable', 'string', 'max:100'],
                'tracer.relevansi_jurusan' => ['nullable', 'in:ya,tidak'],
                'tracer.tahun_mulai' => ['nullable', 'digits:4'],
                'tracer.institusi_nama' => ['nullable', 'string', 'max:150'],
                'tracer.institusi_bidang' => ['nullable', 'string', 'max:100'],
                'tracer.institusi_alamat' => ['nullable', 'string', 'max:255'],
                'tracer.pendapatan_range' => ['nullable', 'string', 'max:50'],
                'tracer.catatan' => ['nullable', 'string'],
            ]);

            $tracerData = $validated['tracer'] ?? [];
            $tracer = TracerAlumni::firstOrNew(['user_id' => $user->id]);
            $tracer->fill($tracerData);
            $tracer->user_id = $user->id;
            $tracer->save();

            return redirect()->route('admin.profile-user.edit', $userId)
                ->with('status', 'Tracer alumni berhasil diperbarui')
                ->with('activeTab', 'tracer');
        }

        // Update Data Diri
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'no_telp' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'in:L,P,l,p'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'password' => ['nullable', 'min:8'],
            'status' => ['nullable', 'in:active,inactive'],
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        if (empty($validated['password'] ?? '')) {
            unset($validated['password']);
        }

        if (isset($validated['jenis_kelamin'])) {
            $jk = strtoupper($validated['jenis_kelamin']);
            $validated['jenis_kelamin'] = in_array($jk, ['L', 'P']) ? $jk : null;
        }

        if (isset($validated['status'])) {
            $status = strtolower($validated['status']);
            $validated['status'] = in_array($status, ['active', 'inactive']) ? $status : null;
        }

        $user->update($validated);

        return redirect()->route('admin.profile-user.edit', $userId)
            ->with('status', 'Profil berhasil diperbarui')
            ->with('activeTab', 'data');
    }

    public function deleteBerkas(int $userId, int $berkasId)
    {
        $user = User::findOrFail($userId);
        $berkas = Berkas::where('id', $berkasId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Hapus file dari storage
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($berkas->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($berkas->file_path);
        }

        $berkas->delete();

        return redirect()->route('admin.profile-user.edit', $userId)
            ->with('status', 'Berkas berhasil dihapus')
            ->with('activeTab', 'berkas');
    }
}
