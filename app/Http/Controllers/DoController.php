<?php

namespace App\Http\Controllers;

use App\Models\DoModel;
use App\Models\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoController extends Controller
{
    /**
     * HALAMAN INVENTORY DO
     */
    public function index($year)
    {
        $inventarydo = DoModel::with('files')
            ->where('year', $year)
            ->orderBy('position') // WAJIB pakai ini
            ->get();

        return view('inventori.do', compact('inventarydo', 'year'));
    }


    /**
     * CREATE DATA DO
     */
    public function store(Request $request, $year)
    {
        $request->validate([
            'project' => 'required|string',
            'vendor'  => 'required|string',
        ]);

        $lastPosition = DoModel::where('year', $year)->max('position');

        DoModel::create([
            'project'  => $request->project,
            'vendor'   => $request->vendor,
            'year'     => $year,
            'position' => $lastPosition ? $lastPosition + 1 : 1,
        ]);

        return redirect()
            ->route('view-do', ['year' => $year])
            ->with('success', 'Data DO berhasil ditambahkan');
    }

    /**
     * UPDATE PROJECT & VENDOR
     */
    public function update(Request $request, $id)
    {
        $do = DoModel::findOrFail($id);

        $request->validate([
            'project' => 'required|string',
            'vendor'  => 'required|string',
        ]);

        $do->update([
            'project' => $request->project,
            'vendor'  => $request->vendor,
        ]);

        return back()->with('success', 'Data DO berhasil diperbarui');
    }

    /**
     * 🔥 UPLOAD FILE + UPDATE TANGGAL DO / BAST
     */
public function uploadFile(Request $request, $id)
{
    $do = DoModel::findOrFail($id);

    $do->update([
        'tanggal_do'   => $request->tanggal_do,
        'nomor_do'     => $request->nomor_do,
        'tanggal_bast' => $request->tanggal_bast,
    ]);

    if (!$request->type || !$request->hasFile('file')) {
        return back()->with('success', 'Data berhasil diperbarui');
    }

    $folderMap = [
        'pdf_do'           => 'do/pdf',
        'foto_do'          => 'do/foto',
        'pdf_bast'         => 'bast/pdf',
        'foto_bast'        => 'bast/foto',
        'pdf_tanda_terima' => 'tanda-terima/pdf',
    ];

    $singleTypes = ['pdf_do', 'pdf_bast'];

    if (in_array($request->type, $singleTypes)) {

        $oldFiles = ProjectFile::where('do_id', $id)
                        ->where('type', $request->type)
                        ->get();

        foreach ($oldFiles as $old) {
            Storage::disk('public')->delete($old->file_path);
            $old->delete();
        }
    }

    foreach ($request->file('file') as $file) {

        $originalName = $file->getClientOriginalName();
        $originalName = str_replace(' ', '_', $originalName);

        $path = $file->storeAs(
            $folderMap[$request->type],
            $originalName,
            'public'
        );

        ProjectFile::create([
            'do_id'     => $id,
            'type'      => $request->type,
            'file_path' => $path,
        ]);
    }

    return back()->with('success', 'Data & file berhasil diperbarui');
}

    /**
     * DELETE DATA DO + FILE
     */
    public function destroy($id)
    {
        $do = DoModel::with('files')->findOrFail($id);
        $deletedPosition = $do->position;
        $year = $do->year;

        foreach ($do->files as $file) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
        }

        $do->delete();

        // 🔥 RAPATKAN URUTAN
        DoModel::where('year', $year)
            ->where('position', '>', $deletedPosition)
            ->decrement('position');

        return back()->with('success', 'Data DO berhasil dihapus');
    }

    /**
     * DETAIL
     */
    public function getDetail(Request $request)
    {
        $do = DoModel::with('files')->find($request->id);

        if (!$do) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($do);
    }

public function reorder(Request $request)
{
    foreach ($request->order as $item) {

        DoModel::where('id', $item['id'])
            ->update(['position' => $item['position']]);
    }

    return response()->json([
        'status' => 'success'
    ]);
}

public function deleteFile(Request $request, $id)
{
    $file = ProjectFile::findOrFail($id);

    // hapus file fisik
    if (Storage::disk('public')->exists($file->file_path)) {
        Storage::disk('public')->delete($file->file_path);
    }

    // hapus database
    $file->delete();

    // 🔥 kalau request dari AJAX
    if ($request->ajax()) {
        return response()->json([
            'success' => true
        ]);
    }

    // fallback kalau bukan AJAX
    return back()->with('success', 'Foto berhasil dihapus');
}
}
