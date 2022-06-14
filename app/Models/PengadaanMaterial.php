<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengadaanMaterial extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'id',
        'normalisasi',
        'nama',
        'deskripsi',
        'satuan',
        'harga',
        'jumlah',
        'pengadaan_id',
        'base_material_id'
    ];
}
