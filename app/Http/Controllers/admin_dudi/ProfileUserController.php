<?php

namespace App\Http\Controllers\admin_dudi;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lamaran;
use App\Models\Berkas;
use App\Models\TracerAlumni;

class ProfileUserController extends Controller
{
    public function index(int $userId)
    {
        $user = User::findOrFail($userId);
        $berkas = Berkas::where('user_id', $user->id)->latest()->get();
        $lamarans = Lamaran::with('lowongan')->where('user_id', $user->id)->latest()->get();
        $tracer = TracerAlumni::with(['jurusan', 'angkatan', 'kegiatan'])->where('user_id', $user->id)->first();

        return view('admin_dudi.profile-user.index', compact('user', 'berkas', 'lamarans', 'tracer'));
    }
}
