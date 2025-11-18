<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\asetjual;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use App\Imports\AsetJualImport;
use App\Exports\AsetJualExport;
use Maatwebsite\Excel\Excel as ExcelWriter;

class asetController extends Controller
{
    public function aset()
    {
       $asset_jual = Asetjual::orderBy('created_at', 'desc')->get();
return view('inventori.aset', compact('asset_jual'));
    }


     public function store(Request $request)
    {
        $request->validate([
            'pn' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'merk' => 'required|string',
            'tipe' => 'required|string',
            'ukuran' => 'string|max:100',
            'dimensi' => 'string|max:100',
            'qty' => 'required|int|min:1',
            'sn' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
        ]);

        asetjual::create($request->all());

        return redirect()->route('view-aset')->with('success', 'Data berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'pn' => 'required|string|max:100',
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'merk' => 'required|string',
            'tipe' => 'required|string',
            'ukuran' => 'required|string',
            'dimensi' => 'required|string|max:100',
            'qty' => 'required|int|min:1',
            'sn' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
        ]);

        $inventaris = asetjual::findOrFail($id);
        $inventaris->update([
            'pn' => $request->pn,
            'nama_barang' => $request->nama_barang,
            'jenis' => $request->jenis,
            'ukuran' => $request->ukuran,
            'dimensi' => $request->dimensi,
            'qty' =>$request->qty,
            'sn'=>$request->sn,
            'lokasi'=>$request->lokasi,
        ]);

        return redirect()->back()->with('success', 'Data inventaris berhasil diperbarui!');
    }

    /**
     * ❌ Hapus data
     */
    public function destroy($id)
    {
        $inventaris = asetjual::findOrFail($id);
        $inventaris->delete();

        return redirect()->back()->with('success', 'Data inventaris berhasil dihapus!');
    }

     public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new AsetJualImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data inventaris berhasil diimport!');
    }

    public function export(Request $request)
    {
        // Ambil parameter filter dari form
        $nama_barang = $request->input('nama_barang');
        $jenis = $request->input('jenis');
        $ukuran = $request->input('ukuran');

        // Query data sesuai filter
        $query = Asetjual::query();

        if ($nama_barang) $query->where('nama_barang', $nama_barang);
        if ($jenis) $query->where('jenis', $jenis);
        if ($ukuran) $query->where('ukuran', $ukuran);

        $data = $query->get([
            'pn',
            'jenis',
            'merk',
            'tipe',
            'ukuran',
            'dimensi',
            'qty',
            'sn',
            'lokasi',
            'created_at',
        ]);

        // Buat header
        $exportData = new Collection();
        $exportData->push([
            'No',
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
            'Tanggal Dibuat',
        ]);

        // Isi data
        foreach ($data as $index => $item) {
            $exportData->push([
                $index + 1,
                $item->pn,
                $item->nama_barang,
                $item->jenis,
                $item->merk,
                $item->tipe,
                $item->ukuran,
                $item->dimensi,
                $item->qty,
                $item->sn,
                $item->lokasi,
                $item->created_at ? $item->created_at->format('d-m-Y') : '',
            ]);
        }

        // Export ke Excel tanpa export class
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
            'Data_Aset_Jual_' . now()->format('Ymd_His') . '.xlsx',
            ExcelWriter::XLSX
        );
    }



 public function filter(Request $request)
    {
        $query = Asetjual::query();

        // Filter nama barang (jika diisi)
        if ($request->filled('nama_barang')) {
            $query->where('nama_barang', $request->nama_barang);
        }

        // Filter jenis (jika diisi)
        if ($request->filled('jenis')) {
            $query->where('jenis', 'like', '%' . $request->jenis . '%');
        }

        // Filter deskripsi (jika diisi)
        if ($request->filled('ukuran')) {
            $query->where('ukuran', 'like', '%' . $request->deskripsi . '%');
        }

        // Ambil hasil filter
        $asset_jual = $query->orderBy('created_at', 'desc')->get();

        // Kirim hasilnya ke view yang sama
        return view('inventori.aset', compact('asset_jual'));
    }

}
