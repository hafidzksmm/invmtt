<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;


class projek extends Model
{
    use HasFactory;
    use LogsActivity; 

    
    protected $table = 'inventaryprojek';

    protected $fillable = [
        'pn',
        'nama_barang',
        'jenis',
        'tipe',
        'merk',
        'ukuran',
        'jumlah',
        'lokasi',
        'sn',
    ];

    public $timestamps = true;
}