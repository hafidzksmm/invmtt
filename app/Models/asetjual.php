<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asetjual extends Model
{
    use HasFactory;
    
    
    protected $table = 'asset_jual';

    protected $fillable = [
        'pn',
        'nama_barang',
        'jenis',
        'merk',
        'tipe',
        'ukuran',
        'dimensi',
        'qty',
        'sn',
        'lokasi',
    ];

    public $timestamps = true;
}
