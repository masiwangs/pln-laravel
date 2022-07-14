<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skki extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable =[
        'id',
        'skki',
        'prk_skki',
        'wbs_jasa',
        'wbs_material',
        'prk_id',
        'basket',
    ];

    public function prks() {
        return $this->hasMany(Prk::class);
    }

    public function files() {
        return $this->hasMany(SkkiFile::class);
    }

    public function jasas() {
        return $this->hasMany(SkkiJasa::class);
    }

    public function materials() {
        return $this->hasMany(SkkiMaterial::class);
    }

    public function getWbsJasaAttribute() {
        return collect($this->jasas)->sum('harga');
    }

    public function getWbsMaterialAttribute() {
        return collect($this->materials)->map(function ($item){return $item->jumlah*$item->harga;} )->sum();
    }
}
