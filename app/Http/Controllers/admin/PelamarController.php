<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PelamarController extends Controller
{
    public function index()
    {
        $pelamars = User::whereIn('role', ['pelamar_alumni', 'pelamar_umum'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.pengguna.pelamar', compact('pelamars'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|min:2|max:150',
            'role' => ['required', Rule::in(['pelamar_alumni', 'pelamar_umum'])],
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'status' => 'required|in:active,inactive',
            'no_telp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'status' => $request->status,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'avatar' => $avatarPath,
        ]);

        return redirect()->route('admin.pelamar.index')->with('success', 'Pelamar berhasil ditambahkan');
    }

    public function update(Request $request, User $pelamar)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|min:2|max:150',
            'role' => ['required', Rule::in(['pelamar_alumni', 'pelamar_umum'])],
            'email' => 'required|email|max:191|unique:users,email,' . $pelamar->id,
            'password' => 'nullable|confirmed|min:8',
            'status' => 'required|in:active,inactive',
            'no_telp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $avatarPath = $pelamar->avatar;
        if ($request->hasFile('avatar')) {
            if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
                Storage::disk('public')->delete($avatarPath);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $pelamar->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'avatar' => $avatarPath,
            'status' => $request->status,
            ...($request->filled('password') ? ['password' => $request->password] : []),
        ]);

        return redirect()->route('admin.pelamar.index')->with('success', 'Pelamar berhasil diperbarui');
    }

    public function destroy(User $pelamar)
    {
        if ($pelamar->avatar && Storage::disk('public')->exists($pelamar->avatar)) {
            Storage::disk('public')->delete($pelamar->avatar);
        }
        $pelamar->delete();
        return redirect()->route('admin.pelamar.index')->with('success', 'Pelamar berhasil dihapus');
    }
}
