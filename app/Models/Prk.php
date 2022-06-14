<?php

namespace App\Models;

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
        'basket'
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
}
