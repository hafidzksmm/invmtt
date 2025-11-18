<?php

namespace App\Imports;

use App\Models\asetjual;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AsetJualImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new AsetJual([
            'pn' => $row['pn'],
            'nama_barang' => $row['nama_barang'],
            'jenis'       => $row['jenis'],
            'merk'       => $row['merk'],
            'tipe'       => $row['tipe'],
            'ukuran'      => $row['ukuran'],
            'dimensi'     => $row['dimensi'],
            'qty'         => $row['qty'],
            'sn'      => $row['sn'],
            'lokasi'      => $row['lokasi'],
        ]);
    }
}
