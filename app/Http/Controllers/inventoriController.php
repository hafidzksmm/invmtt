<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ws;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use App\Imports\InventoriImport;
use Maatwebsite\Excel\Excel as ExcelWriter;

class inventoriController extends Controller
{
    public function ws()
    {
        $inventaris = ws::orderBy('created_at', 'desc')->get();
        return view('inventori.ws', compact('inventaris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pn' => 'nullable|string',
            'nama_barang' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
            'dimensi' => 'nullable|string|max:100',
            'qty' => 'nullable|integer|min:1',
            'lokasi' => 'nullable|string|max:255',
            'sn' => 'nullable|string',
        ]);

        // parse PN & SN (set ke array kosong bila textarea kosong)
        $pnRaw = (string) $request->pn;
        $snRaw = (string) $request->sn;

        $pnList = $pnRaw === '' ? [] : array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $pnRaw)));
        $snList = $snRaw === '' ? [] : array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $snRaw)));

        ws::create([
            'pn' => json_encode(array_values($pnList)),
            'nama_barang' => $request->nama_barang,
            'merk' => $request->merk,
            'deskripsi' => $request->deskripsi,
            'dimensi' => $request->dimensi,
            'qty' => $request->qty,
            'lokasi' => $request->lokasi,
            'sn' => json_encode(array_values($snList)),
        ]);

        return redirect()->route('view-ws')->with('success', 'Data berhasil ditambahkan.');
    }
// UPDATE
public function update(Request $request, $id)
{
    $request->validate([
        'pn' => 'nullable|string',
        'nama_barang' => 'nullable|string|max:255',
        'merk' => 'nullable|string|max:100',
        'deskripsi' => 'nullable|string|max:255',
        'dimensi' => 'nullable|string|max:100',
        'qty' => 'nullable|integer|min:1',
        'lokasi' => 'nullable|string|max:255',
        'sn' => 'nullable|string',
    ]);

    $inventaris = ws::findOrFail($id);

    $pnRaw = (string) $request->pn;
    $snRaw = (string) $request->sn;

    $pnList = $pnRaw === '' ? [] : array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $pnRaw)));
    $snList = $snRaw === '' ? [] : array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $snRaw)));

    $inventaris->update([
        'pn' => json_encode(array_values($pnList)),
        'nama_barang' => $request->nama_barang,
        'merk' => $request->merk,
        'deskripsi' => $request->deskripsi,
        'dimensi' => $request->dimensi,
        'qty' => $request->qty,
        'lokasi' => $request->lokasi,
        'sn' => json_encode(array_values($snList)),
    ]);

    return redirect()->back()->with('success', 'Data inventaris berhasil diperbarui!');
}
    public function destroy($id)
    {
        $inventaris = ws::findOrFail($id);
        $inventaris->delete();

        return redirect()->back()->with('success', 'Data inventaris berhasil dihapus!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new InventoriImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data inventaris berhasil diimport!');
    }

    public function export(Request $request)
    {
        $query = ws::query();

        if ($request->filled('nama_barang')) {
            $query->where('nama_barang', 'like', '%' . $request->nama_barang . '%');
        }
        if ($request->filled('merk')) {
            $query->where('merk', 'like', '%' . $request->merk . '%');
        }
        if ($request->filled('deskripsi')) {
            $query->where('deskripsi', 'like', '%' . $request->deskripsi . '%');
        }

        $data = $query->get([
            'pn', 'nama_barang', 'merk', 'deskripsi', 'dimensi', 'qty', 'lokasi', 'sn', 'created_at',
        ]);

        $exportData = new Collection();
        $exportData->push(['No','Produk No', 'Nama Barang', 'Merk', 'Deskripsi', 'Dimensi', 'Qty','Serial No', 'Lokasi', 'Tanggal Dibuat']);

        foreach ($data as $index => $item) {
            $exportData->push([
                $index + 1,
                implode(", ", json_decode($item->pn, true) ?? []),
                $item->nama_barang,
                $item->merk,
                $item->deskripsi,
                $item->dimensi,
                $item->qty,
                implode(", ", json_decode($item->sn, true) ?? []),
                $item->lokasi,
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
            'Data_Inventaris_' . now()->format('Ymd_His') . '.xlsx',
            ExcelWriter::XLSX
        );
    }

    public function filter(Request $request)
    {
        $query = ws::query();

        if ($request->filled('nama_barang')) {
            $query->where('nama_barang', 'like', '%' . $request->nama_barang . '%');
        }
        if ($request->filled('merk')) {
            $query->where('merk', 'like', '%' . $request->merk . '%');
        }
        if ($request->filled('deskripsi')) {
            $query->where('deskripsi', 'like', '%' . $request->deskripsi . '%');
        }

        $inventaris = $query->orderBy('created_at', 'desc')->get();
        return view('inventori.ws', compact('inventaris'));
    }
}
