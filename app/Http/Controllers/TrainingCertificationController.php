<?php

namespace App\Http\Controllers;

use App\Models\TrainingProvider;
use App\Models\TrainingCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingCertificationController extends Controller
{
    /**
     * HALAMAN UTAMA: daftar logo penyedia sertifikasi (Dell, Lenovo, D-Link, Sophos, dll)
     */
    public function index()
    {
        $providers = TrainingProvider::withCount('certificates')
            ->orderBy('position')
            ->orderBy('id')
            ->get();

        return view('training-certification.index', compact('providers'));
    }

    /**
     * TAMBAH PENYEDIA SERTIFIKASI (VENDOR)
     */
    public function storeProvider(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $lastPosition = TrainingProvider::max('position');

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('training/logos', 'public');
        }

        TrainingProvider::create([
            'name'      => $request->name,
            'logo_path' => $logoPath,
            'position' => $lastPosition ? $lastPosition + 1 : 1,
        ]);

        return back()->with('success', 'Penyedia sertifikasi berhasil ditambahkan');
    }

    /**
     * UPDATE PENYEDIA SERTIFIKASI (nama & logo)
     */
    public function updateProvider(Request $request, $id)
    {
        $provider = TrainingProvider::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('logo')) {
            if ($provider->logo_path) {
                Storage::disk('public')->delete($provider->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('training/logos', 'public');
        }

        $provider->update($data);

        return back()->with('success', 'Penyedia sertifikasi berhasil diperbarui');
    }

    /**
     * HAPUS PENYEDIA SERTIFIKASI (otomatis hapus semua sertifikat & filenya)
     */
    public function destroyProvider($id)
    {
        $provider = TrainingProvider::with('certificates')->findOrFail($id);
        $deletedPosition = $provider->position;

        foreach ($provider->certificates as $cert) {
            Storage::disk('public')->delete($cert->file_path);
            $cert->delete();
        }

        if ($provider->logo_path) {
            Storage::disk('public')->delete($provider->logo_path);
        }

        $provider->delete();

        // rapatkan urutan
        TrainingProvider::where('position', '>', $deletedPosition)->decrement('position');

        return back()->with('success', 'Penyedia sertifikasi berhasil dihapus');
    }

    /**
     * REORDER (drag & drop urutan logo vendor)
     */
    public function reorderProvider(Request $request)
    {
        foreach ($request->order as $item) {
            TrainingProvider::where('id', $item['id'])
                ->update(['position' => $item['position']]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * AJAX: ambil daftar sertifikat milik satu vendor (dipakai untuk isi modal popup)
     */
    public function getCertificates($providerId)
    {
        $provider = TrainingProvider::findOrFail($providerId);

        $certificates = TrainingCertificate::where('provider_id', $providerId)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($cert) {
                return [
                    'id'           => $cert->id,
                    'title'        => $cert->title,
                    'holder_name'  => $cert->holder_name,
                    'issued_date'  => optional($cert->issued_date)->format('d M Y'),
                    'expired_date' => optional($cert->expired_date)->format('d M Y'),
                    'note'         => $cert->note,
                    'image_url'    => asset('storage/' . $cert->file_path),
                ];
            });

        return response()->json([
            'provider'     => [
                'id'   => $provider->id,
                'name' => $provider->name,
            ],
            'certificates' => $certificates,
        ]);
    }

    /**
     * UPLOAD SERTIFIKAT BARU (gambar) UNTUK VENDOR TERTENTU
     */
    public function storeCertificate(Request $request, $providerId)
    {
        TrainingProvider::findOrFail($providerId);

        $request->validate([
            'title'        => 'nullable|string|max:255',
            'holder_name'  => 'nullable|string|max:255',
            'issued_date'  => 'nullable|date',
            'expired_date' => 'nullable|date',
            'note'         => 'nullable|string',
            'file'         => 'required|image|max:2048',
        ]);

        $path = $request->file('file')->store('training/certificates', 'public');

        TrainingCertificate::create([
            'provider_id'  => $providerId,
            'title'        => $request->title,
            'holder_name'  => $request->holder_name,
            'issued_date'  => $request->issued_date,
            'expired_date' => $request->expired_date,
            'note'         => $request->note,
            'file_path'    => $path,
        ]);

        return back()->with('success', 'Sertifikat berhasil diupload');
    }

    /**
     * UPDATE DATA SERTIFIKAT (opsional ganti gambar)
     */
    public function updateCertificate(Request $request, $id)
    {
        $cert = TrainingCertificate::findOrFail($id);

        $request->validate([
            'title'        => 'nullable|string|max:255',
            'holder_name'  => 'nullable|string|max:255',
            'issued_date'  => 'nullable|date',
            'expired_date' => 'nullable|date',
            'note'         => 'nullable|string',
            'file'         => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'holder_name', 'issued_date', 'expired_date', 'note']);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($cert->file_path);
            $data['file_path'] = $request->file('file')->store('training/certificates', 'public');
        }

        $cert->update($data);

        return back()->with('success', 'Sertifikat berhasil diperbarui');
    }

    /**
     * HAPUS SERTIFIKAT
     */
    public function destroyCertificate(Request $request, $id)
    {
        $cert = TrainingCertificate::findOrFail($id);

        Storage::disk('public')->delete($cert->file_path);
        $cert->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Sertifikat berhasil dihapus');
    }
}
