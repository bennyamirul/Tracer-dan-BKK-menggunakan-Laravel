<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TracerAlumni extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tracer_alumni';

    protected $fillable = [
        'user_id',
        'jurusan_id',
        'angkatan_id',
        'kegiatan_id',
        'posisi_peran',
        'relevansi_jurusan',
        'tahun_mulai',
        'institusi_nama',
        'institusi_bidang',
        'institusi_alamat',
        'pendapatan_range',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'angkatan_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }
}
