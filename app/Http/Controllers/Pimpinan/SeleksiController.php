<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use App\Models\FolderDokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeleksiController extends Controller
{
    // Menampilkan daftar folder yang perlu/siap diseleksi
    public function index()
    {
        $folders = FolderDokumentasi::with(['kegiatan', 'dokumentasi'])->latest()->get();

        return view('pimpinan.seleksi.index', compact('folders'));
    }

    // Menampilkan isi foto/video dalam folder untuk proses seleksi
    public function show($id)
    {
        $folder = FolderDokumentasi::with(['kegiatan', 'dokumentasi.uploader'])->findOrFail($id);
        $files = Dokumentasi::where('folder_id', $id)->get();

        return view('pimpinan.seleksi.show', compact('folder', 'files'));
    }

    // Menandai 1 file sebagai "dipilih"
    public function pilih($id)
    {
        $file = Dokumentasi::findOrFail($id);
        $file->update([
            'status' => 'dipilih',
            'selected_by' => Auth::id(),
        ]);

        return back()->with('success', 'File berhasil dipilih untuk diedit.');
    }

    // Menandai 1 file sebagai "ditolak/abaikan"
    public function tolak($id)
    {
        $file = Dokumentasi::findOrFail($id);
        $file->update([
            'status' => 'ditolak',
            'selected_by' => Auth::id(),
        ]);

        return back()->with('success', 'File ditolak.');
    }

    // Menyimpan masal centang file & mengirimkan instruksi ke Editor
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

    // 3. UPDATE STATUS FOLDER / KEGIATAN SUPAYA KETAHUAN SUDAH DISELEKSI
    $folder = FolderDokumentasi::findOrFail($id);
    $folder->update([
        'status' => 'selesai_seleksi' // Atau atur sesuai kolom status di tabel folder/kegiatanmu
    ]);

    // 4. ALIKAN REDIRECT KE HALAMAN MONITORING KEGIATAN
    return redirect()->route('pimpinan.kegiatan')
        ->with('success', 'Hasil seleksi dan instruksi berhasil dikirimkan ke Tim Editor!');
}
}