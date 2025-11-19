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
            'pn' => $row['pn']?? null,
            'nama_barang' => $row['nama_barang']?? null,
            'jenis'       => $row['jenis']?? null,
            'merk'       => $row['merk']?? null,
            'tipe'       => $row['tipe']?? null,
            'ukuran'      => $row['ukuran']?? null,
            'dimensi'     => $row['dimensi']?? null,
            'qty'         => $row['qty']?? null,
            'sn'      => $row['sn']?? null,
            'lokasi'      => $row['lokasi']?? null,
        ]);
    }
}
