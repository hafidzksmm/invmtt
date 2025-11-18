<?php

namespace App\Imports;

use App\Models\ws;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InventoriImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Pastikan header di file Excel sesuai kolom di database
        return new ws([
            'pn' => $row['pn'] ,
            'nama_barang' => $row['nama_barang'] ,
            'merk'        => $row['merk'],
            'deskripsi'   => $row['deskripsi'], 
            'dimensi'     => $row['dimensi'] ,
            'qty'         => $row['qty'] ,
            'lokasi'      => $row['lokasi'] ,
            'sn'      => $row['sn'],
        ]);
    }
}
