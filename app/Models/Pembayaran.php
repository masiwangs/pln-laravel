<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'id',
        'status',
        'basket',
        'pelaksanaan_id',
    ];
    
    public function kontrak() {
        return $this->belongsTo(Kontrak::class);
    }

    public function pelaksanaan() {
        return $this->belongsTo(Pelaksanaan::class);
    }

    public function tahapans() {
        return $this->hasMany(PembayaranPertahap::class);
    }

    public function files() {
        return $this->hasMany(PembayaranFile::class);
    }
}
