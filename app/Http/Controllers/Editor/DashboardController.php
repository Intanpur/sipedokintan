<?php
namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\FolderDokumentasi;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DashboardController extends Controller
{
    /**
     * Menampilkan Tampilan Utama Dashboard Editor (Metrik & Summary).
     */
    public function index()
    {
        $folders = FolderDokumentasi::with(['kegiatan', 'dokumentasi' => function($q) {
            $q->whereIn('status', ['dipilih', 'editing', 'selesai']);
        }])
        ->whereHas('dokumentasi', function($q) {
            $q->whereIn('status', ['dipilih', 'editing', 'selesai']);
        })
        ->latest()
        ->get();

        // PERBAIKAN: Ambil instruksi edit dari tabel Dokumentasi
        $instruksiTerakhir = Dokumentasi::with('folder')
            ->whereNotNull('instruksi_edit')
            ->where('instruksi_edit', '!=', '')
            ->latest('updated_at')
            ->first();

        return view('editor.dashboardeditor', compact('folders', 'instruksiTerakhir'));
    }
    /**
     * Memproses dan mengunduh seluruh file mentah dalam 1 folder sebagai berkas ZIP.
     */
    public function downloadZip($folderId)
    {
        $folder = FolderDokumentasi::findOrFail($folderId);
        
        $files = Dokumentasi::where('folder_id', $folderId)
            ->whereIn('status', ['dipilih', 'editing', 'selesai'])
            ->get();

        if ($files->isEmpty()) {
            return back()->with('error', 'Tidak ada file mentah yang diproses pada folder ini.');
        }

        $zip = new ZipArchive;
        $zipFileName = 'BAHAN_EDIT_' . str_replace(' ', '_', preg_replace('/[^A-Za-z0-9\-]/', '', $folder->nama_folder)) . '_' . time() . '.zip';
        
        $tempDir = storage_path('app/public/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipPath = $tempDir . '/' . $zipFileName;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($files as $file) {
                if (Storage::disk('public')->exists($file->path_file)) {
                    $absolutePath = Storage::disk('public')->path($file->path_file);
                    $zip->addFile($absolutePath, basename($file->path_file));
                }
            }
            $zip->close();
        }

        if (!file_exists($zipPath)) {
            return back()->with('error', 'Gagal membuat file ZIP. Pastikan file fisik mentahan ada di storage.');
        }

        // Tandai berkas yang diunduh menjadi status 'editing'
        Dokumentasi::where('folder_id', $folderId)
            ->where('status', 'dipilih')
            ->update(['status' => 'editing']);

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
    /**
     * Menampilkan Tampilan Proses Editing
     */
    public function prosesEditing()
    {
        $folders = FolderDokumentasi::with(['kegiatan', 'dokumentasi'])
            ->whereHas('dokumentasi', function($q) {
                $q->whereIn('status', ['dipilih', 'editing', 'selesai']);
            })
            ->latest()
            ->get();

        return view('editor.proses_editing', compact('folders'));
    }
}