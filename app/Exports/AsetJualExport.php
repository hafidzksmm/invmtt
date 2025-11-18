<?php

namespace App\Exports;

use App\Models\asetjual;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AsetJualExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return AsetJual::select('pn','nama_barang', 'jenis','merk','tipe', 'ukuran', 'dimensi', 'qty', 'lokasi','sn',)->get();
    }

    public function headings(): array
    {
        return [
            'Produk No',
            'Nama Barang',
            'Jenis',
            'Merk',
            'Tipe',
            'Ukuran',
            'Dimensi',
            'Qty',
            'Serial No',
            'Lokasi',
        ];
    }
}
