<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use App\Models\FolderDokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper; 
use App\Models\DisposisiPimpinan;
use Illuminate\Support\Str;

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

            $doc = Dokumentasi::create([
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

            // REKAM LOG AKTIVITAS: UPLOAD FILE
            LogHelper::record(
                'upload',
                $doc->id,
                'Mengunggah file ' . $file->getClientOriginalName() . ' ke folder ' . $folder->nama_folder
            );
        }
    }

    // OTOMATIS BUAT DISPOSISI AGAR LANGSUNG MASUK MENU KURASI PIMPINAN
    $pimpinanId = $folder->kegiatan->pimpinan_id ?? null;
    if ($pimpinanId) {
        DisposisiPimpinan::firstOrCreate(
            [
                'folder_id'   => $folder->id,
                'pimpinan_id' => $pimpinanId,
            ],
            [
                'token'         => Str::random(40),
                'status_review' => 'pending',
            ]
        );
    }

    return redirect()
        ->route('petugas.folder.show', $folder->id)
        ->with('success', 'Dokumentasi berhasil diupload');
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
        $namaLama = $dok->nama_file;

        $dok->update([
            'nama_file' => $request->nama_file,
        ]);

        // REKAM LOG AKTIVITAS: UBAH NAMA FILE
        LogHelper::record(
            'edit_upload',
            $dok->id,
            'Mengubah nama file dari "' . $namaLama . '" menjadi "' . $request->nama_file . '"'
        );

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

        // REKAM LOG AKTIVITAS: BAGIKAN KE PIMPINAN
        LogHelper::record(
            'selected',
            $dok->id,
            'Membagikan file ' . $dok->nama_file . ' ke pimpinan'
        );

        return redirect()
            ->back()
            ->with('success', 'Dokumentasi berhasil dibagikan ke pimpinan');
    }

    public function destroy($id)
    {
        $dok = Dokumentasi::findOrFail($id);

        $folderId = $dok->folder_id;
        $namaFile = $dok->nama_file;

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

        // REKAM LOG AKTIVITAS: HAPUS FILE
        LogHelper::record(
            'archive',
            null,
            'Menghapus file dokumentasi: ' . $namaFile
        );
        
        $dok->delete();

        return redirect()
            ->route('petugas.folder.show', $folderId)
            ->with('success', 'Dokumentasi berhasil dihapus');
    }
    public function shareSingleFileToPimpinan(Request $request, $id)
{
    $request->validate([
        'pimpinan_id' => 'required|exists:users,id',
    ]);

    $file = Dokumentasi::findOrFail($id);

    // Buat record disposisi khusus agar file terlihat oleh pimpinan terpilih
    DisposisiPimpinan::create([
        'folder_id'     => $file->folder_id,
        'pimpinan_id'   => $request->pimpinan_id,
        'token'         => Str::random(32),
        'status_review' => 'pending',
    ]);

    // Rekam Log Aktivitas
    LogHelper::record(
        'share',
        $file->id,
        'Petugas membagikan file susulan (' . $file->nama_file . ') ke Pimpinan.'
    );

    return back()->with('success', 'File ' . $file->nama_file . ' berhasil dibagikan ke Pimpinan!');
}
}