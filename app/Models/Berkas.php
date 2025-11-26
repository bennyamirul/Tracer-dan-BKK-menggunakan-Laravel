<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berkas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'berkas';

    protected $fillable = [
        'user_id',
        'jenis',
        'file_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
