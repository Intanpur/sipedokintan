<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FolderDokumentasi;
use App\Models\Dokumentasi;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class FolderDokumentasiController extends Controller
{
    public function index(Request $request)
    {
        $query = FolderDokumentasi::with([
            'kegiatan',
            'user'
        ])
        ->withCount([
            'dokumentasi as foto_count' => function ($q) {
                $q->where('tipe_file', 'foto');
            },
            'dokumentasi as video_count' => function ($q) {
                $q->where('tipe_file', 'video');
            }
        ]);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_folder', 'like', '%' . $request->search . '%')
                ->orWhereHas('kegiatan', function ($k) use ($request) {
                    $k->where('nama_kegiatan', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('user', function ($u) use ($request) {
                    $u->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        switch ($request->sort) {
            case 'terlama':
                $query->oldest();
                break;

            case 'terbanyak':
                $query->withCount('dokumentasi as files_count')
                      ->orderByDesc('files_count');
                break;

            default:
                $query->latest();
                break;
        }

        $folders = $query->paginate(10)->withQueryString();

        $totalFolder = FolderDokumentasi::count();
        $totalFoto = Dokumentasi::where('tipe_file', 'foto')->count();
        $totalVideo = Dokumentasi::where('tipe_file', 'video')->count();
        $totalUkuranStorage = $this->formatSize(
            Dokumentasi::sum('ukuran_file')
        );

        return view('admin.folder.index', compact(
            'folders',
            'totalFolder',
            'totalFoto',
            'totalVideo',
            'totalUkuranStorage'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_folder' => 'required|string|max:255',
            'kegiatan_id' => 'required|exists:kegiatan,id',
        ]);

        // 1. Simpan Folder Baru
        $folder = FolderDokumentasi::create([
            'nama_folder' => $request->nama_folder,
            'kegiatan_id' => $request->kegiatan_id,
            'user_id'     => Auth::id(),
        ]);

        // 2. Simpan Log Aktivitas
        if (class_exists(ActivityLog::class)) {
            ActivityLog::create([
                'user_id'  => Auth::id(),
                'activity' => 'Membuat folder baru: ' . $folder->nama_folder,
                'status'   => 'Selesai',
            ]);
        }

        return redirect()->back()->with('success', 'Folder berhasil dibuat!');
    }

    public function show($id)
    {
        $folder = FolderDokumentasi::with([
            'kegiatan',
            'creator',
            'dokumentasi'
        ])->findOrFail($id);

        $files = $folder->dokumentasi;
        $totalFoto = $files->where('tipe_file', 'foto')->count();

       return view('admin.folder.show', compact('folder', 'files', 'totalFoto'));
    }

    public function downloadZip(Request $request, $id)
    {
        $type = $request->query('type', 'all'); // 'all', 'foto', atau 'video'
        $folder = FolderDokumentasi::findOrFail($id);

        // Filter dokumentasi berdasarkan tipe jika ditentukan
        $query = Dokumentasi::where('folder_dokumentasi_id', $id);
        if ($type === 'foto') {
            $query->where('tipe_file', 'foto');
        } elseif ($type === 'video') {
            $query->where('tipe_file', 'video');
        }
        $files = $query->get();

        if ($files->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada file untuk diunduh.');
        }

        $zip = new ZipArchive();
        $zipFileName = 'Folder_' . \Illuminate\Support\Str::slug($folder->nama_folder) . '_' . $type . '_' . time() . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($files as $file) {
                // Pastikan path file sesuai dengan lokasi penyimpanan Anda di storage
                $filePath = storage_path('app/public/' . $file->path_file);
                
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $file->nama_file ?? basename($filePath));
                }
            }
            $zip->close();
        }

        // Catat log aktivitas jika ada
        if (class_exists(ActivityLog::class)) {
            ActivityLog::create([
                'user_id'  => Auth::id(),
                'activity' => 'Mendownload ZIP (' . $type . ') dari folder: ' . $folder->nama_folder,
                'status'   => 'Selesai',
            ]);
        }

        // Download ZIP lalu hapus file temp setelah dikirim ke browser
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    private function formatSize($size)
    {
        if ($size >= 1073741824) {
            return round($size / 1073741824, 2) . ' GB';
        }

        if ($size >= 1048576) {
            return round($size / 1048576, 2) . ' MB';
        }

        if ($size >= 1024) {
            return round($size / 1024, 2) . ' KB';
        }

        return $size . ' B';
    }
}