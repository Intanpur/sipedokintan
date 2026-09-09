<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\FolderDokumentasi;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogHelper; // Import LogHelper

class EditingController extends Controller
{
    /**
     * Draf status yang diizinkan (mencakup lowercase & Capitalize).
     */
    private array $allowedStatuses = ['dipilih', 'editing', 'selesai', ];

    /**
     * Menampilkan daftar folder & berkas bahan mentah yang siap diproses.
     * Mengait ke Route: GET /editor/editing -> editor.editing.index
     */
    public function index()
    {
        $statuses = $this->allowedStatuses;

        $folders = FolderDokumentasi::with(['kegiatan', 'dokumentasi' => function($q) use ($statuses) {
                // Filter relasi dokumentasi yang di-load ke View
                $q->whereIn('status', $statuses);
            }])
            ->whereHas('dokumentasi', function($q) use ($statuses) {
                // Hanya ambil folder yang memiliki minimal 1 file dengan status terkait
                $q->whereIn('status', $statuses);
            })
            ->latest()
            ->get();

        return view('editor.proses_editing', compact('folders'));
    }

    /**
     * Menampilkan detail folder tertentu.
     */
    public function show($id)
    {
        $statuses = $this->allowedStatuses;

        $folder = FolderDokumentasi::with(['kegiatan', 'dokumentasi' => function($q) use ($statuses) {
            $q->whereIn('status', $statuses);
        }])->findOrFail($id);

        return view('editor.show_editing', compact('folder'));
    }

    /**
     * Unduh per berkas (Eceran) secara aman.
     */
    public function download($id)
    {
        $file = Dokumentasi::findOrFail($id);

        if (empty($file->path_file)) {
            return back()->with('error', 'Path file tidak terdaftar di database.');
        }

        $fullPath = storage_path('app/public/' . $file->path_file);

        if (!file_exists($fullPath) || is_dir($fullPath)) {
            return back()->with('error', 'File fisik tidak ditemukan di storage server.');
        }

        $downloadName = !empty($file->nama_file) ? $file->nama_file : basename($file->path_file);

        // REKAM LOG AKTIVITAS: EDITOR DOWNLOAD MENTAHAN
        LogHelper::record(
            'download',
            $file->id,
            'Editor mengunduh mentahan file: ' . $downloadName
        );

        return response()->download($fullPath, $downloadName);
    }

    /**
     * Unggah berkas hasil editing final.
     */
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_final' => 'required|mimes:mp4,mkv,jpg,png,jpeg|max:102400',
        ]);

        $doc = Dokumentasi::findOrFail($id);
        $path = $request->file('file_final')->store('dokumentasi/final', 'public');

        $doc->update([
            'file_final_path' => $path,
            'status'          => 'selesai',
            'editor_id'       => Auth::id(),
            'edited_at'       => now(),
        ]);

        // REKAM LOG AKTIVITAS: UPLOAD HASIL EDIT FINAL
        LogHelper::record(
            'edit_upload',
            $doc->id,
            'Editor mengunggah hasil editan final untuk file: ' . $doc->nama_file
        );

        return back()->with('success', 'Hasil editan final berhasil diunggah!');
    }

    /**
     * Mengubah status proses editing menjadi selesai.
     * Mengait ke Route: PUT /editor/editing/{id}/selesai -> editor.editing.selesai
     */
    public function selesai($id)
    {
        $doc = Dokumentasi::findOrFail($id);
        $doc->update(['status' => 'selesai']);

        // REKAM LOG AKTIVITAS: UBAH STATUS SELESAI
        LogHelper::record(
            'approve',
            $doc->id,
            'Editor menandai proses editing file ' . $doc->nama_file . ' sebagai SELESAI'
        );

        return back()->with('success', 'Status berkas berhasil diubah menjadi SELESAI!');
    }
}