<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Dokumentasi;
use App\Models\FolderDokumentasi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKegiatan = Kegiatan::count();
        $totalFolder   = FolderDokumentasi::count();
        $totalFoto     = Dokumentasi::where('tipe_file', 'foto')->count();
        $totalVideo    = Dokumentasi::where('tipe_file', 'video')->count();

        $kegiatanTerbaru = Kegiatan::withCount('folder')
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
        // Load relasi folder, dokumentasi, dan user pengirim melalui folder
        $kegiatan = Kegiatan::with(['folder.dokumentasi', 'folder.user'])
                    ->latest()
                    ->get();

        return view('pimpinan.kegiatan', compact('kegiatan'));
    }

    public function dokumentasi()
    {
        $files = Dokumentasi::with(['folder.kegiatan', 'uploader'])->latest()->get();

        return view('pimpinan.dokumentasi', compact('files'));
    }

    public function laporan()
    {
        return view('pimpinan.laporan');
    }
}