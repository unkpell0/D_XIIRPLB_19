<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    
    protected $fillable =[
        'nama',
        'jenis',
        'merek',
        'tipe',
        'plat_nomor',
        'tahun_produksi',
        'image',
        'status',
    ];

    protected $casts = [
        'tahun_produksi' => 'integer',
    ];

    protected $primaryKey = 'id';

    // public $incrementing = false; // Jika bukan tipe integer auto-increment

    // protected $keyType = 'string'; // Jika menggunakan string
}
