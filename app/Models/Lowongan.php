<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lowongan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lowongan_kerja';

    protected $fillable = [
        'perusahaan_id',
        'user_id',
        'judul',
        'posisi',
        'pendidikan_min',
        'pendidikan_jurusan',
        'tanggal_dibuat',
        'batas_lamaran',
        'deskripsi',
        'status',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class, 'lowongan_id');
    }
}
