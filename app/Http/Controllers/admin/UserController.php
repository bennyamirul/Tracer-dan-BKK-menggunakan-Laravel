<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['admin_sekolah', 'admin_dudi'])->orderBy('nama')->get();
        // Hanya tampilkan perusahaan yang belum memiliki admin (user_id null)
        $perusahaans = Perusahaan::whereNull('user_id')->orderBy('nama_perusahaan', 'asc')->get();
        return view('admin.pengguna.admin', compact('users', 'perusahaans'));
    }

    public function show(User $user)
    {
        return view('admin.pengguna.show', compact('user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|min:2|max:150',
            'role' => 'required|in:admin_sekolah,admin_dudi',
            'dudi' => [
                'nullable',
                Rule::exists('perusahaan', 'id')->whereNull('user_id'),
            ],
            'no_telp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
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

        // Jika admin_dudi, tautkan ke perusahaan terpilih dengan mengisi perusahaan.user_id
        if ($user->role === 'admin_dudi' && $request->filled('dudi')) {
            $perusahaan = Perusahaan::find($request->dudi);
            if ($perusahaan) {
                $perusahaan->user_id = $user->id;
                $perusahaan->save();
            }
        }

        return redirect()->route('admin.user.index')->with('success', 'Admin berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|min:2|max:150',
            'role' => 'required|in:admin_sekolah,admin_dudi',
            'dudi' => [
                'nullable',
                // izinkan tetap memilih perusahaan yang sudah terkait dengan user ini saat edit
                Rule::exists('perusahaan', 'id')->where(function ($q) use ($user) {
                    $q->whereNull('user_id')->orWhere('user_id', $user->id);
                }),
            ],
            'no_telp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'email' => 'required|email|max:191|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $avatarPath = $user->avatar;
        if ($request->hasFile('avatar')) {
            if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
                Storage::disk('public')->delete($avatarPath);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'avatar' => $avatarPath,
            'status' => $request->status,
            // password opsional saat update
            ...($request->filled('password') ? ['password' => $request->password] : []),
        ]);

        // Reset link perusahaan lama jika user ini sebelumnya admin_dudi
        Perusahaan::where('user_id', $user->id)->update(['user_id' => null]);
        if ($user->role === 'admin_dudi' && $request->filled('dudi')) {
            Perusahaan::where('id', $request->dudi)->update(['user_id' => $user->id]);
        }

        return redirect()->route('admin.user.index')->with('success', 'Admin berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        // Lepaskan keterkaitan perusahaan jika ada
        Perusahaan::where('user_id', $user->id)->update(['user_id' => null]);
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'Admin berhasil dihapus');
    }
}
