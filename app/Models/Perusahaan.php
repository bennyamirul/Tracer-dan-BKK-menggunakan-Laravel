<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Perusahaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'perusahaan';

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'logo',
        'alamat',
        'kontak',
        'email',
        'deskripsi',
    ];
    public function getLogoPathAttribute(): ?string
    {
        if (!$this->logo) {
            return null;
        }
        // Normalisasi jika terlanjur simpan dengan prefix 'storage/'
        return \Illuminate\Support\Str::startsWith($this->logo, 'storage/')
            ? \Illuminate\Support\Str::after($this->logo, 'storage/')
            : $this->logo;
    }
    public function lowongan()
    {
        return $this->hasMany(Lowongan::class);
    }
}
