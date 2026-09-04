<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\DisposisiPimpinan;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;

class KurasiController extends Controller
{
    // Menampilkan halaman kurasi via Token Magic Link WA
    public function show($token)
    {
        $disposisi = DisposisiPimpinan::where('token', $token)
    ->with(['folder.kegiatan', 'pimpinan'])
    ->firstOrFail();

        return view('pimpinan.kurasi_wa', compact('disposisi', 'files'));
    }

    // Menyimpan centang pilihan pimpinan & teruskan ke editor
    public function submit(Request $request, $token)
    {
        $disposisi = DisposisiPimpinan::where('token', $token)->firstOrFail();
        $selectedFileIds = $request->input('selected_files', []);

        // Ubah status file yang dicentang pimpinan menjadi 'dipilih' agar bisa di-download Editor
        Dokumentasi::whereIn('id', $selectedFileIds)->update([
            'status' => 'dipilih',
            'selected_by' => $disposisi->pimpinan_id,
            'instruksi_edit' => $request->catatan_pimpinan
        ]);

        $disposisi->update([
            'status_review' => 'selesai',
            'catatan_pimpinan' => $request->catatan_pimpinan
        ]);

        return back()->with('success', 'File terpilih berhasil didisposisikan ke Tim Editor!');
    }
}