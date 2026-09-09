<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\DisposisiPimpinan;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use App\Helpers\LogHelper; // Import LogHelper
use Illuminate\Support\Facades\Storage;

class KurasiController extends Controller
{
    public function show($token)
    {
        $disposisi = DisposisiPimpinan::where('token', $token)
            ->with(['folder.kegiatan', 'pimpinan'])
            ->firstOrFail();

        // Ambil berkas dari folder disposisi terkait
        $files = Dokumentasi::where('folder_id', $disposisi->folder_id)->get();

        return view('pimpinan.kurasi_wa', compact('disposisi', 'files'));
    }

   public function submit(Request $request, $token)
{
    $disposisi = DisposisiPimpinan::where('token', $token)->firstOrFail();
    $selectedFileIds = $request->input('selected_files', []);

    Dokumentasi::whereIn('id', $selectedFileIds)->update([
        'status' => 'dipilih',
        'selected_by' => $disposisi->pimpinan_id,
        'instruksi_edit' => $request->catatan_pimpinan
    ]);

    $disposisi->update([
        'status_review' => 'selesai',
        'catatan_pimpinan' => $request->catatan_pimpinan
    ]);

    // REKAM LOG AKTIVITAS
    LogHelper::record(
        'selected',
        null,
        'Pimpinan menyelesaikan kurasi via WA untuk folder: ' . ($disposisi->folder->nama_folder ?? 'ID ' . $disposisi->folder_id) . ' (' . count($selectedFileIds) . ' file dipilih)'
    );

    // KEMBALI KE HALAMAN /pimpinan/kurasi
    return redirect()->route('pimpinan.kurasi.index')->with('success', 'File terpilih berhasil didisposisikan ke Tim Editor!');
}
    

public function destroyFile($token, $id)
{
    $disposisi = DisposisiPimpinan::where('token', $token)->firstOrFail();
    $file = Dokumentasi::where('folder_id', $disposisi->folder_id)->findOrFail($id);

    // Hapus file fisik dari storage
    if ($file->path_file && Storage::disk('public')->exists($file->path_file)) {
        Storage::disk('public')->delete($file->path_file);
    }

    // Hapus data dari database
    $file->delete();

    return back()->with('success', 'File berhasil dihapus!');
}
}