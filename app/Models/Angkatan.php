<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Angkatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tahun_angkatan';

    protected $fillable = [
        'tahun',
        'nama',
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];

    /**
     * Get the formatted tahun attribute
     */
    public function getTahunFormattedAttribute()
    {
        return $this->tahun;
    }

    /**
     * Get the display name (nama or tahun if nama is null)
     */
    public function getDisplayNameAttribute()
    {
        return $this->tahun ?: "Angkatan {$this->tahun}";
    }
}
