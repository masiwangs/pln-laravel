<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrakMaterial extends Model
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
        'kontrak_id',
        'base_material_id'
    ];
}
