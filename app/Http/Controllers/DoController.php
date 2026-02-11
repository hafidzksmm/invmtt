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
            ->latest()
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

        DoModel::create([
            'project' => $request->project,
            'vendor'  => $request->vendor,
            'year'    => $year, // 🔥 INI KUNCI UTAMA
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
     * 🔥 UPLOAD FILE (SUPPORT MULTIPLE FOTO + SINGLE PDF)
     */
    public function uploadFile(Request $request, $id)
    {
        $do = DoModel::findOrFail($id);

        $request->validate([
            'type' => 'required|in:pdf_do,foto_do,pdf_bast,foto_bast',
            'file' => 'required',
        ]);

        $files = $request->file('file');
        if (!is_array($files)) {
            $files = [$files];
        }

        // mapping folder
        $folderMap = [
            'pdf_do'    => 'do/pdf',
            'foto_do'   => 'do/foto',
            'pdf_bast'  => 'bast/pdf',
            'foto_bast' => 'bast/foto',
        ];

        /**
         * PDF = SATU FILE (HAPUS YANG LAMA)
         */
        if (in_array($request->type, ['pdf_do', 'pdf_bast'])) {

            $request->validate([
                'file.*' => 'mimes:pdf',
                'note'   => 'nullable|string'
            ]);

            $oldFiles = ProjectFile::where('do_id', $id)
                ->where('type', $request->type)
                ->get();

            foreach ($oldFiles as $old) {
                Storage::disk('public')->delete($old->file_path);
                $old->delete();
            }
        }

        /**
         * FOTO = BISA BANYAK
         */
        if (in_array($request->type, ['foto_do', 'foto_bast'])) {
            $request->validate([
                'file.*' => 'image|mimes:jpg,jpeg,png',
            ]);
        }

        foreach ($files as $file) {

            $path = $file->store(
                $folderMap[$request->type],
                'public'
            );

            ProjectFile::create([
                'do_id'     => $id,
                'type'      => $request->type,
                'file_path' => $path,
                'note'      => in_array($request->type, ['pdf_do','pdf_bast'])
                                ? $request->note
                                : null,
            ]);
        }

        return back()->with('success', 'File berhasil diupload');
    }

    /**
     * DELETE DATA DO + FILE
     */
    public function destroy($id)
    {
        $do = DoModel::with('files')->findOrFail($id);

        foreach ($do->files as $file) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
        }

        $do->delete();

        return back()->with('success', 'Data DO berhasil dihapus');
    }

    /**
     * DETAIL (OPTIONAL)
     */
    public function getDetail(Request $request)
    {
        $do = DoModel::with('files')->find($request->id);

        if (!$do) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($do);
    }
}
