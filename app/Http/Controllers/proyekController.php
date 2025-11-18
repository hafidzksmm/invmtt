<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\projek;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use App\Imports\ProjekImport;     // <-- pastikan class ini ada: app/Imports/ProjekImport.php
use App\Exports\ProjekExport;     // <-- optional, jika Anda memakai export class
use Maatwebsite\Excel\Excel as ExcelWriter;

class proyekController extends Controller
{
    /**
     * Tampilkan halaman inventori projek
     */
    public function projek()
    {
        $inventaryprojek = projek::orderBy('created_at', 'desc')->get();
        return view('inventori.proyek', compact('inventaryprojek'));
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'pn' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:255',
            'jenis'       => 'required|string|max:100',
            'tipe'        => 'required|string|max:255',
            'merk'        => 'required|string|max:255',
            'ukuran'      => 'nullable|string|max:100',
            'jumlah'      => 'required|integer|min:1',
            'lokasi'      => 'required|string|max:255',
            'sn'      => 'required|string|max:100',
        ]);

        projek::create($request->only([
            'pn','nama_barang','jenis','tipe','merk','ukuran','jumlah','lokasi','sn'
        ]));

        return redirect()->route('view-projek')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Update data berdasarkan id
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pn' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:255',
            'jenis'       => 'required|string|max:100',
            'tipe'        => 'required|string',
            'merk'        => 'required|string',
            'ukuran'      => 'nullable|string|max:100',
            'jumlah'      => 'required|integer|min:1',
            'lokasi'      => 'required|string|max:255',
            'sn'      => 'required|string|max:100',
        ]);

        $inventaris = projek::findOrFail($id);
        $inventaris->update($request->only([
            'pn','nama_barang','jenis','tipe','merk','ukuran','jumlah','lokasi'.'sn'
        ]));

        return redirect()->back()->with('success', 'Data inventaris berhasil diperbarui!');
    }

    /**
     * Hapus data
     */
    public function destroy($id)
    {
        $inventaris = projek::findOrFail($id);
        $inventaris->delete();

        return redirect()->back()->with('success', 'Data inventaris berhasil dihapus!');
    }

    /**
     * Import data dari Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            // Pastikan class App\Imports\ProjekImport benar-benar ada
            Excel::import(new ProjekImport, $request->file('file'));
        } catch (\Throwable $e) {
            // Jika ada error class not found / lainnya, beri pesan yang jelas
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Data inventaris berhasil diimport!');
    }

    /**
     * Export data ke Excel (menggunakan anonymous export)
     */
    public function export(Request $request)
    {
        // Ambil parameter filter
        $filters = $request->only(['nama_barang','jenis','tipe','merk','ukuran']);

        // Query data sesuai filter (cari partial match)
        $query = projek::query();
        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $query->where($key, 'like', "%{$value}%");
            }
        }

        $data = $query->get([
            'pn','nama_barang','jenis','tipe','merk','ukuran','jumlah','sn','lokasi','created_at'
        ]);

        // Siapkan collection untuk export
        $exportData = new Collection();
        $exportData->push([
            'No','Produk No','Nama Barang','Jenis','Tipe','Merk','Ukuran','Jumlah','Serial No','Lokasi','Tanggal Dibuat'
        ]);

        foreach ($data as $index => $item) {
            $exportData->push([
                $index + 1,
                $item->pn,
                $item->nama_barang,
                $item->jenis,
                $item->tipe,
                $item->merk,
                $item->ukuran,
                $item->jumlah,
                $item->lokasi,
                $item->sn,
                $item->created_at ? $item->created_at->format('d-m-Y') : '',
            ]);
        }

        return Excel::download(
            new class($exportData) implements \Maatwebsite\Excel\Concerns\FromCollection {
                protected $exportData;
                public function __construct($exportData)
                {
                    $this->exportData = $exportData;
                }
                public function collection()
                {
                    return $this->exportData;
                }
            },
            'Data_Projek_' . now()->format('Ymd_His') . '.xlsx',
            ExcelWriter::XLSX
        );
    }

    /**
     * Filter - mengembalikan view atau JSON jika AJAX
     */
    public function filter(Request $request)
    {
        $query = projek::query();

        if ($request->filled('nama_barang')) {
            $query->where('nama_barang', 'like', '%' . $request->nama_barang . '%');
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', 'like', '%' . $request->jenis . '%');
        }
        if ($request->filled('tipe')) {
            $query->where('tipe', 'like', '%' . $request->tipe . '%');
        }
        if ($request->filled('merk')) {
            $query->where('merk', 'like', '%' . $request->merk . '%');
        }
        if ($request->filled('ukuran')) {
            $query->where('ukuran', 'like', '%' . $request->ukuran . '%');
        }

        $inventaryprojek = $query->orderBy('created_at', 'desc')->get();

        // Jika dipanggil AJAX, kembalikan JSON agar JS bisa update tabel
        if ($request->ajax()) {
            return response()->json($inventaryprojek);
        }

        // Normal request -> render view
        return view('inventori.proyek', compact('inventaryprojek'));
    }

    /**
     * Ambil detail item (misal untuk modal)
     */
    public function getDetail(Request $request)
    {
        $id = $request->query('id');
        $item = projek::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item tidak ditemukan'], 404);
        }

        return response()->json($item);
    }
}
