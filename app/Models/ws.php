<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class ws extends Model
{
    use HasFactory;
    use LogsActivity; 

    
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
