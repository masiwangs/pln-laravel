<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'id',
        'nomor_kontrak',
        'tgl_kontrak',
        'tgl_awal',
        'tgl_akhir',
        'pelaksana',
        'direksi',
        'pengadaan_id',
        'is_amandemen',
        'versi_amandemen',
        'basket',
    ];

    public function files() {
        return $this->hasMany(KontrakFile::class);
    }

    public function jasas() {
        return $this->hasMany(KontrakJasa::class);
    }

    public function materials() {
        return $this->hasMany(KontrakMaterial::class);
    }
}
