<?php

namespace App\Http\Controllers;

use App\Models\DoModel;
use App\Models\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectFileController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'type'   => 'required|in:pdf_do,pdf_do_disti,foto_do,pdf_bast,foto_bast,pdf_tanda_terima',
            'file'   => 'required',
            'file.*' => 'file|max:10240', // max 10MB per file
        ]);

        $do = DoModel::findOrFail($id);

        $folders = [
            'pdf_do'           => 'do/pdf',
            'pdf_do_disti'     => 'do-disti/pdf',
            'foto_do'          => 'do/foto',
            'pdf_bast'         => 'bast/pdf',
            'foto_bast'        => 'bast/foto',
            'pdf_tanda_terima' => 'tanda-terima/pdf',
        ];

        // Tipe yang hanya boleh punya 1 file (single) → file lama dihapus dulu
        $singleTypes = ['pdf_do', 'pdf_bast'];

        if (in_array($request->type, $singleTypes)) {

            $oldFiles = ProjectFile::where('do_id', $do->id)
                ->where('type', $request->type)
                ->get();

            foreach ($oldFiles as $old) {
                Storage::disk('public')->delete($old->file_path);
                $old->delete();
            }
        }

        // Normalisasi input file jadi array, supaya mendukung
        // input single (name="file") maupun multiple (name="file[]")
        $files = $request->file('file');
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {

            $originalName = str_replace(' ', '_', $file->getClientOriginalName());

            $path = $file->storeAs(
                $folders[$request->type],
                $originalName,
                'public'
            );

            ProjectFile::create([
                'do_id'     => $do->id,
                'type'      => $request->type,
                'file_path' => $path,
            ]);
        }

        return back()->with('success', 'File berhasil diupload');
    }

    public function download($id)
    {
        $file = ProjectFile::findOrFail($id);
        return Storage::disk('public')->download($file->file_path);
    }

    public function destroy($id)
    {
        $file = ProjectFile::findOrFail($id);

        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return back()->with('success', 'File berhasil dihapus');
    }
}