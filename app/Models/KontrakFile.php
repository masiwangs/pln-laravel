<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrakFile extends Model
{
    use HasFactory;
    
    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'id',
        'nama',
        'deskripsi',
        'url',
        'kontrak_id',
    ];
}
