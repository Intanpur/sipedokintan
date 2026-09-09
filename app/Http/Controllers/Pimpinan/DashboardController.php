<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Dokumentasi;
use App\Models\FolderDokumentasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\DisposisiPimpinan;

class DashboardController extends Controller
{
    public function index()
    {
        $pimpinanId = Auth::id();

        // 1. Ambil folder berdasarkan pimpinan_id yang ada di tabel kegiatan
        $folderIds = FolderDokumentasi::whereHas('kegiatan', function($q) use ($pimpinanId) {
            $q->where('pimpinan_id', $pimpinanId);
        })->pluck('id');

        // 2. Hitung statistik
        $totalFolder   = $folderIds->count();
        $totalKegiatan = Kegiatan::where('pimpinan_id', $pimpinanId)->count();

        $totalFoto  = Dokumentasi::whereIn('folder_id', $folderIds)->where('tipe_file', 'foto')->count();
        $totalVideo = Dokumentasi::whereIn('folder_id', $folderIds)->where('tipe_file', 'video')->count();

        // 3. Kegiatan terbaru khusus pimpinan ini
        $kegiatanTerbaru = Kegiatan::where('pimpinan_id', $pimpinanId)
            ->withCount('folder')
            ->latest()
            ->take(5)
            ->get();

        return view('pimpinan.dashboard', compact(
            'totalKegiatan', 
            'totalFolder', 
            'totalFoto', 
            'totalVideo', 
            'kegiatanTerbaru'
        ));
    }

 public function kegiatan()
{
    $pimpinanId = Auth::id();

    // 1. Ambil semua ID Kegiatan yang pimpinan_id-nya adalah pimpinan yang sedang login
    $kegiatanIds = Kegiatan::where('pimpinan_id', $pimpinanId)->pluck('id');

    // 2. Ambil semua folder yang terhubung dengan kegiatan-kegiatan tersebut
    $folders = FolderDokumentasi::whereIn('kegiatan_id', $kegiatanIds)
        ->with(['kegiatan', 'dokumentasi'])
        ->latest()
        ->get();

    // 3. Tampilkan ke view seleksi/kurasi
    return view('pimpinan.seleksi.index', compact('folders'));
}
    public function dokumentasi()
    {
        $pimpinanId = Auth::id();

        // Ambil file dari folder yang kegiatan-nya ditujukan ke pimpinan ini
        $files = Dokumentasi::whereHas('folder.kegiatan', function($q) use ($pimpinanId) {
                    $q->where('pimpinan_id', $pimpinanId);
                })
                ->with(['folder.kegiatan', 'uploader'])
                ->latest()
                ->get();

        return view('pimpinan.dokumentasi', compact('files'));
    }

    public function laporan()
    {
        return view('pimpinan.laporan');
    }

    
}