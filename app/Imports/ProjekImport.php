<?php

namespace App\Imports;

use App\Models\projek;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjekImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Pastikan nama kolom Excel sesuai heading (case-insensitive)
        return new projek([
            'pn' => $row['pn'] ?? null,
            'nama_barang' => $row['nama_barang'] ?? null,
            'jenis'       => $row['jenis'] ?? null,
            'tipe'        => $row['tipe'] ?? null,
            'merk'        => $row['merk'] ?? null,
            'ukuran'      => $row['ukuran'] ?? null,
            'jumlah'      => $row['jumlah'] ?? 0,
            'lokasi'      => $row['lokasi'] ?? null,
            'sn'      => $row['sn'] ?? null,
        ]);
    }
}
