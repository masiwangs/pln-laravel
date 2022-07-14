<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prk extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'id',
        'nama',
        'prk',
        'lot',
        'prioritas',
        'anggaran_jasa',
        'basket',
        'skki_id'
    ];

    public function files() {
        return $this->hasMany(PrkFile::class);
    }

    public function jasas() {
        return $this->hasMany(PrkJasa::class);
    }
    
    public function materials() {
        return $this->hasMany(PrkMaterial::class);
    }

    public function skki() {
        return $this->belongsTo(Skki::class);
    }

    public function getRabJasaAttribute() {
        return collect($this->jasas)->sum('harga');
    }

    public function getRabMaterialAttribute() {
        return collect($this->materials)->map(function ($item){return $item->jumlah*$item->harga;} )->sum();
    }
}
