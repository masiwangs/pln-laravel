<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaksanaanMaterial extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'id',
        'tanggal',
        'tug9',
        'normalisasi',
        'nama',
        'deskripsi',
        'satuan',
        'harga',
        'jumlah',
        'transaksi',
        'pelaksanaan_id',
        'base_material_id',
    ];
}
