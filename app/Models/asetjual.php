<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class asetjual extends Model
{
    use HasFactory;
    use LogsActivity; // 🔥 otomatis catat siapa create/update/delete data ini


    protected $table = 'asset_jual';

    protected $fillable = [
        'pn',
        'nama_barang',
        'jenis',
        'merk',
        'tipe',
        'ukuran',
        'qty',
        'sn',
        'lokasi',
        'position',
    ];

    public $timestamps = true;
}