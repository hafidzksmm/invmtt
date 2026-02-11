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
        dd('MASUK CONTROLLER', $id, $request->all(), $request->hasFile('file'));
        $request->validate([
            'type' => 'required|in:pdf_do,foto_do,pdf_bast,foto_bast',
            'file' => 'required|file|max:10240',
        ]);

        $do = DoModel::findOrFail($id);

        $folders = [
            'pdf_do'    => 'do/pdf',
            'foto_do'   => 'do/foto',
            'pdf_bast'  => 'bast/pdf',
            'foto_bast' => 'bast/foto',
        ];

        $path = $request->file('file')
            ->store($folders[$request->type], 'public');

        ProjectFile::create([
            'do_id'     => $do->id,
            'type'      => $request->type,
            'file_path' => $path,
        ]);

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

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return back()->with('success', 'File berhasil dihapus');
    }
}
