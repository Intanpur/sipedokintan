<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use App\Models\FolderDokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumentasiController extends Controller
{
    public function create($id)
    {
        $folder = FolderDokumentasi::findOrFail($id);

        return view('petugas.unggahdokumentasi', compact('folder'));
    }

    public function store(Request $request, $id)
    {
        $folder = FolderDokumentasi::findOrFail($id);

        // Mendukung input nama array 'files' (dari modal show) atau 'file'
        $uploadedFiles = $request->file('files') ?? $request->file('file');

        $request->validate([
            'files.*' => 'nullable|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:102400',
            'file.*'  => 'nullable|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:102400',
        ]);

        if ($uploadedFiles) {
            foreach ($uploadedFiles as $file) {
                $path = $file->store('dokumentasi', 'public');

                $ext = strtolower($file->getClientOriginalExtension());

                $tipe = in_array($ext, ['mp4', 'mov', 'avi']) ? 'video' : 'foto';

                Dokumentasi::create([
                    'folder_id'      => $folder->id,
                    'uploaded_by'    => Auth::id(),
                    'tipe_file'      => $tipe,
                    'nama_file'      => $file->getClientOriginalName(),
                    'path_file'      => $path,
                    'ukuran_file'    => $file->getSize(),
                    'status_progres' => 'pending'
                ]);

                if ($tipe == 'video') {
                    $folder->increment('total_video');
                } else {
                    $folder->increment('total_foto');
                }
            }
        }

        return redirect()
            ->route('petugas.folder.show', $folder->id)
            ->with('success', 'Dokumentasi berhasil diupload');
    }

    public function view($id)
    {
        $dok = Dokumentasi::findOrFail($id);

        return view('petugas.viewdokumentasi', compact('dok'));
    }

    /**
     * Rename nama file dokumentasi.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_file' => 'required|string|max:255',
        ]);

        $dok = Dokumentasi::findOrFail($id);
        $dok->update([
            'nama_file' => $request->nama_file,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Nama file berhasil diperbarui');
    }

    /**
     * Bagikan file ke pimpinan.
     */
    public function share(Request $request, $id)
    {
        $request->validate([
            'pimpinan_id' => 'required',
            'catatan'     => 'nullable|string',
        ]);

        $dok = Dokumentasi::findOrFail($id);

        // Tambahkan logic notifikasi atau penyimpanan data pembagian di sini jika diperlukan

        return redirect()
            ->back()
            ->with('success', 'Dokumentasi berhasil dibagikan ke pimpinan');
    }

    public function destroy($id)
    {
        $dok = Dokumentasi::findOrFail($id);

        $folderId = $dok->folder_id;

        if (Storage::disk('public')->exists($dok->path_file)) {
            Storage::disk('public')->delete($dok->path_file);
        }

        if ($dok->folder) {
            if ($dok->tipe_file == 'video') {
                $dok->folder->decrement('total_video');
            } else {
                $dok->folder->decrement('total_foto');
            }
        }
        
        $dok->delete();

        return redirect()
            ->route('petugas.folder.show', $folderId)
            ->with('success', 'Dokumentasi berhasil dihapus');
    }
}