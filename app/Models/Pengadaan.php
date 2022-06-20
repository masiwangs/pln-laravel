<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;
    
    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'id',
        'nodin',
        'tgl_nodin',
        'pr',
        'nama',
        'status',
        'basket',
        'skki_id'
    ];

    public function files() {
        return $this->hasMany(PengadaanFile::class);
    }

    public function jasas() {
        return $this->hasMany(PengadaanJasa::class);
    }

    public function materials() {
        return $this->hasMany(PengadaanMaterial::class);
    }

    public function wbs_jasas() {
        return $this->hasMany(PengadaanWbsJasa::class);
    }

    public function wbs_materials() {
        return $this->hasMany(PengadaanWbsMaterial::class);
    }

    public function kontrak() {
        return $this->hasOne(Kontrak::class);
    }
}
