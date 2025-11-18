<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ws extends Model
{
    use HasFactory;

    
    protected $table = 'inventaris';

    protected $fillable = [
        'pn',
        'nama_barang',
        'merk',
        'deskripsi',
        'dimensi',
        'qty',
        // 'satuan',
        'lokasi',
        'sn',
    ];

    public $timestamps = true;
}
