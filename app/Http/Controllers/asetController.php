<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\asetjual;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use App\Imports\AsetJualImport;
use Maatwebsite\Excel\Excel as ExcelWriter;

class asetController extends Controller
{
    public function aset()
    {
        $asset_jual = Asetjual::orderBy('created_at', 'desc')->get();
        return view('inventori.aset', compact('asset_jual'));
    }

    // ===============================
    //  STORE (CREATE)
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'pn' => 'required|string',
            'nama_barang' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'lokasi' => 'required|string|max:255',
        ]);

        // Convert PN & SN menjadi array list (per baris)
    $pnRaw = (string) $request->pn;
    $snRaw = (string) $request->sn;

    $pnList = $pnRaw === '' ? [] : array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $pnRaw)));
    $snList = $snRaw === '' ? [] : array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $snRaw)));


        asetjual::create([
            'pn' => json_encode($pnList),
            'nama_barang' => $request->nama_barang,
            'jenis' => $request->jenis,
            'merk' => $request->merk,
            'tipe' => $request->tipe,
            'ukuran' => $request->ukuran,
            'dimensi' => $request->dimensi,
            'qty' => $request->qty,
            'sn' => json_encode($snList),
            'lokasi' => $request->lokasi,
        ]);

        return redirect()->route('view-aset')->with('success', 'Data berhasil ditambahkan.');
    }

    // ===============================
    //  UPDATE
    // ===============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'pn' => 'required|string',
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'merk' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'ukuran' => 'nullable|string|max:100',
            'dimensi' => 'nullable|string|max:100',
            'qty' => 'required|integer|min:1',
            'sn' => 'required|string',
            'lokasi' => 'required|string|max:255',
        ]);

        // Convert PN & SN menjadi array list (per baris)
    $pnRaw = (string) $request->pn;
    $snRaw = (string) $request->sn;

    $pnList = $pnRaw === '' ? [] : array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $pnRaw)));
    $snList = $snRaw === '' ? [] : array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $snRaw)));


        $inventaris = asetjual::findOrFail($id);

        $inventaris->update([
            'pn' => json_encode($pnList),
            'nama_barang' => $request->nama_barang,
            'jenis' => $request->jenis,
            'merk' => $request->merk,
            'tipe' => $request->tipe,
            'ukuran' => $request->ukuran,
            'dimensi' => $request->dimensi,
            'qty' => $request->qty,
            'sn' => json_encode($snList),
            'lokasi' => $request->lokasi,
        ]);

        return redirect()->back()->with('success', 'Data inventaris berhasil diperbarui!');
    }

    // ===============================
    //  DELETE
    // ===============================
    public function destroy($id)
    {
        $inventaris = asetjual::findOrFail($id);
        $inventaris->delete();

        return redirect()->back()->with('success', 'Data inventaris berhasil dihapus!');
    }

    // ===============================
    //  IMPORT
    // ===============================
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new AsetJualImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data inventaris berhasil diimport!');
    }

    // ===============================
    //  EXPORT
    // ===============================
    public function export(Request $request)
    {
        $nama_barang = $request->input('nama_barang');
        $jenis = $request->input('jenis');
        $ukuran = $request->input('ukuran');

        $query = Asetjual::query();

        if ($nama_barang) $query->where('nama_barang', $nama_barang);
        if ($jenis) $query->where('jenis', $jenis);
        if ($ukuran) $query->where('ukuran', $ukuran);

        $data = $query->get();

        $exportData = new Collection();

        $exportData->push([
            'No', 'Produk No', 'Nama Barang', 'Jenis', 'Merk', 'Tipe', 'Ukuran',
            'Dimensi', 'Qty', 'Serial No', 'Lokasi', 'Tanggal Dibuat'
        ]);

        foreach ($data as $index => $item) {
            $pn = json_decode($item->pn, true);
            $sn = json_decode($item->sn, true);

            $exportData->push([
                $index + 1,
                is_array($pn) ? implode(", ", $pn) : $item->pn,
                $item->nama_barang,
                $item->jenis,
                $item->merk,
                $item->tipe,
                $item->ukuran,
                $item->dimensi,
                $item->qty,
                is_array($sn) ? implode(", ", $sn) : $item->sn,
                $item->lokasi,
                $item->created_at ? $item->created_at->format('d-m-Y') : '',
            ]);
        }

        return Excel::download(
            new class($exportData) implements \Maatwebsite\Excel\Concerns\FromCollection {
                protected $exportData;
                public function __construct($exportData) { $this->exportData = $exportData; }
                public function collection() { return $this->exportData; }
            },
            'Data_Aset_Jual_' . now()->format('Ymd_His') . '.xlsx',
            ExcelWriter::XLSX
        );
    }

    // ===============================
    //  FILTER
    // ===============================
    public function filter(Request $request)
    {
        $query = Asetjual::query();

        if ($request->filled('nama_barang')) {
            $query->where('nama_barang', $request->nama_barang);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', 'like', '%' . $request->jenis . '%');
        }

        if ($request->filled('ukuran')) {
            $query->where('ukuran', 'like', '%' . $request->ukuran . '%');
        }

        $asset_jual = $query->orderBy('created_at', 'desc')->get();

        return view('inventori.aset', compact('asset_jual'));
    }
}
