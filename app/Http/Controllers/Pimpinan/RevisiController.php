<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use App\Models\FolderDokumentasi;
use Illuminate\Http\Request;

class RevisiController extends Controller
{
    // Menampilkan daftar berkas yang membutuhkan instruksi revisi
    public function index()
    {
        $revisiFiles = Dokumentasi::whereNotNull('instruksi_edit')
    ->with(['folder.kegiatan', 'uploader'])
    ->latest()
    ->get();

        return view('pimpinan.revisi.index', compact('revisiFiles'));
    }

    // Menyimpan catatan instruksi revisi baru pada berkas
    public function store(Request $request)
    {
        $request->validate([
            'file_id' => 'required|exists:dokumentasis,id',
            'instruksi_edit' => 'required|string',
        ]);

        $file = Dokumentasi::findOrFail($request->file_id);
        $file->update([
            'status' => 'revisi',
            'instruksi_edit' => $request->instruksi_edit,
        ]);

        return back()->with('success', 'Catatan revisi berhasil disimpan.');
    }

    // Memperbarui catatan instruksi revisi
    public function update(Request $request, $id)
    {
        $request->validate([
            'instruksi_edit' => 'required|string',
        ]);

        $file = Dokumentasi::findOrFail($id);
        $file->update([
            'instruksi_edit' => $request->instruksi_edit,
        ]);

        return back()->with('success', 'Catatan revisi berhasil diperbarui.');
    }

    // Menghapus/Membatalkan status revisi pada berkas
    public function destroy($id)
    {
        $file = Dokumentasi::findOrFail($id);
        $file->update([
            'instruksi_edit' => null,
            'status' => 'dipilih',
        ]);

        return back()->with('success', 'Catatan revisi berhasil dihapus.');
    }
}