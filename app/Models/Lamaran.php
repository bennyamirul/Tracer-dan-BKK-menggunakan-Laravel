<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lamaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lamaran';

    protected $fillable = [
        'user_id',
        'lowongan_id',
        'status',
        'tanggal_lamaran',
        'tanggal_wawancara',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }
}
