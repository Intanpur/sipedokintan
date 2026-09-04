<?php
namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\FolderDokumentasi;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EditingController extends Controller
{
    /**
     * Menampilkan daftar folder & berkas bahan mentah yang siap diproses.
     * Mengait ke Route: GET /editor/editing -> editor.editing.index
     */
    public function index()
    {
        $folders = FolderDokumentasi::with(['kegiatan', 'dokumentasi'])
            ->whereHas('dokumentasi', function($q) {
                $q->whereIn('status', ['dipilih', 'editing', 'selesai']);
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
        $folder = FolderDokumentasi::with(['kegiatan', 'dokumentasi' => function($q) {
            $q->whereIn('status', ['dipilih', 'editing', 'selesai']);
        }])->findOrFail($id);

        return view('editor.show_editing', compact('folder'));
    }

    /**
     * Unduh per berkas (Eceran).
     */
    /**
     * Unduh per berkas (Eceran) secara aman.
     */
   /**
     * Unduh per berkas (Eceran) secara aman.
     */
    public function download($id)
    {
        $file = \App\Models\Dokumentasi::findOrFail($id);

        if (empty($file->path_file)) {
            return back()->with('error', 'Path file tidak terdaftar di database.');
        }

        $fullPath = storage_path('app/public/' . $file->path_file);

        if (!file_exists($fullPath) || is_dir($fullPath)) {
            return back()->with('error', 'File fisik tidak ditemukan di storage server.');
        }

        $downloadName = !empty($file->nama_file) ? $file->nama_file : basename($file->path_file);

        return response()->download($fullPath, $downloadName);
    }
     
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

        return back()->with('success', 'Status berkas berhasil diubah menjadi SELESAI!');
    }
}