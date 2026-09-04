<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\ActivityLog; // Menggunakan model ActivityLog Anda

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::with(['createdBy', 'folder.dokumentasi'])
            ->latest()
            ->get();

        // Hitung statistik menggunakan model ActivityLog dan kolom 'activity'
        $totalKegiatan = $kegiatan->count();
        $totalUpload   = ActivityLog::where('activity', 'upload')->count();
        $totalDownload = ActivityLog::where('activity', 'download')->count();

        return view('admin.kegiatan.index', compact(
            'kegiatan',
            'totalKegiatan',
            'totalUpload',
            'totalDownload'
        ));
    }

   public function show($id)
{
    $kegiatan = Kegiatan::with([
        'createdBy',
        'folder.dokumentasi.uploader',
    ])->findOrFail($id);

    // Ambil ID dokumentasi dari relasi folder (jika folder ada)
    $dokumentasiIds = optional($kegiatan->folder)
        ->dokumentasi
        ?->pluck('id')
        ?->toArray() ?? [];

    // Ambil log aktivitas berkas kegiatan ini menggunakan ActivityLog
    $logs = ActivityLog::whereIn('dokumentasi_id', $dokumentasiIds)
        ->with(['user', 'dokumentasi'])
        ->latest()
        ->get();

    return view('admin.kegiatan.show', compact('kegiatan', 'logs'));
}
}