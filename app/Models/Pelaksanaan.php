<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaksanaan extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'id',
        'spk',
        'progress',
        'kontrak_id',
        'basket'
    ];

    public function files() {
        return $this->hasMany(PelaksanaanFile::class);
    }

    public function kontrak() {
        return $this->belongsTo(Kontrak::class);
    }

    public function jasas() {
        return $this->hasMany(PelaksanaanJasa::class);
    }

    public function materials() {
        return $this->hasMany(PelaksanaanMaterial::class);
    }
}
