<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use App\Models\FolderDokumentasi;
use App\Models\DisposisiPimpinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogHelper; // Import LogHelper

class SeleksiController extends Controller
{
    // Menampilkan daftar folder KHUSUS untuk pimpinan yang sedang login
    public function index()
    {
        $pimpinanId = Auth::id();

        // Ambil folder yang pernah didisposisikan ke pimpinan ini
        $folders = FolderDokumentasi::whereHas('disposisi', function($query) use ($pimpinanId) {
                        $query->where('pimpinan_id', $pimpinanId);
                    })
                    ->with(['kegiatan', 'dokumentasi'])
                    ->latest()
                    ->get();

        return view('pimpinan.seleksi.index', compact('folders'));
    }

    // Menampilkan isi file dengan validasi hak akses pimpinan
    public function show($id)
    {
        $pimpinanId = Auth::id();

        // Pastikan pimpinan hanya bisa buka folder miliknya
        $folder = FolderDokumentasi::whereHas('disposisi', function($query) use ($pimpinanId) {
                        $query->where('pimpinan_id', $pimpinanId);
                    })
                    ->with(['kegiatan', 'dokumentasi.uploader'])
                    ->findOrFail($id);

        $files = Dokumentasi::where('folder_id', $id)->get();

        return view('pimpinan.seleksi.show', compact('folder', 'files'));
    }

    public function pilih($id)
    {
        $file = Dokumentasi::findOrFail($id);
        $file->update([
            'status' => 'dipilih',
            'selected_by' => Auth::id(),
        ]);

        // REKAM LOG AKTIVITAS: PILIH FILE
        LogHelper::record(
            'selected',
            $file->id,
            'Pimpinan memilih file: ' . $file->nama_file . ' untuk diedit'
        );

        return back()->with('success', 'File berhasil dipilih untuk diedit.');
    }

    public function tolak($id)
    {
        $file = Dokumentasi::findOrFail($id);
        $file->update([
            'status' => 'ditolak',
            'selected_by' => Auth::id(),
        ]);

        // REKAM LOG AKTIVITAS: TOLAK FILE
        LogHelper::record(
            'reject',
            $file->id,
            'Pimpinan menolak file: ' . $file->nama_file
        );

        return back()->with('success', 'File ditolak.');
    }

    public function kirimEditor(Request $request, $id)
    {
        $selectedFileIds = $request->input('selected_files', []);

        // 1. Update file yang tidak dicentang
        Dokumentasi::where('folder_id', $id)->whereNotIn('id', $selectedFileIds)->update([
            'status' => 'proses'
        ]);

        // 2. Update file yang dicentang pimpinan
        Dokumentasi::whereIn('id', $selectedFileIds)->update([
            'status' => 'dipilih',
            'selected_by' => Auth::id(),
            'instruksi_edit' => $request->input('catatan_pimpinan')
        ]);

        // 3. Update status folder & disposisi
        $folder = FolderDokumentasi::findOrFail($id);
        $folder->update([
            'status' => 'selesai_seleksi'
        ]);

        DisposisiPimpinan::where('folder_id', $id)
            ->where('pimpinan_id', Auth::id())
            ->update(['status_review' => 'selesai']);

        // REKAM LOG AKTIVITAS: KIRIM KE EDITOR
        LogHelper::record(
            'assign_editor',
            null,
            'Pimpinan mengirim ' . count($selectedFileIds) . ' file dari folder "' . $folder->nama_folder . '" ke Tim Editor'
        );

        return redirect()->route('pimpinan.kegiatan')
            ->with('success', 'Hasil seleksi dan instruksi berhasil dikirimkan ke Tim Editor!');
    }
}