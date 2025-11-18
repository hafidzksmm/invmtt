<?php

namespace App\Exports;

use App\Models\ws;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoriExport implements FromCollection, WithHeadings
{
    /**
     * Ambil data dari tabel inventaris (model ws)
     */
    public function collection()
    {
        return ws::select(
            'pn',
            'nama_barang',
            'merk',
            'deskripsi',
            'dimensi',
            'qty',
            'satuan',
            'lokasi',
            'sn'
        )->get();
    }

    /**
     * Buat header kolom untuk file Excel
     */
    public function headings(): array
    {
        return [
            'Produk No',
            'Nama Barang',
            'Merk',
            'Deskripsi',
            'Dimensi',
            'Qty',
            'Serial No',
            'Lokasi',
        ];
    }
}
