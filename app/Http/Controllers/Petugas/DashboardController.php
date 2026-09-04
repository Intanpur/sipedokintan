<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\FolderDokumentasi;
use App\Models\Dokumentasi;
use App\Models\User; // 1. Tambahkan import model User
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | LIST PIMPINAN (AMBIL USER DENGAN ROLE/JABATAN PIMPINAN)
        |--------------------------------------------------------------------------
        */
        // Sesuaikan 'pimpinan' dengan nilai role di database kamu
        $listPimpinan = User::where('role', 'pimpinan')->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL KEGIATAN
        |--------------------------------------------------------------------------
        */

        $totalKegiatan = Kegiatan::where(
            'created_by',
            $user->id
        )->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL FOLDER
        |--------------------------------------------------------------------------
        */

        $totalFolder = FolderDokumentasi::whereHas(
            'kegiatan',
            function ($query) use ($user) {
                $query->where(
                    'created_by',
                    $user->id
                );
            }
        )->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL FOTO
        |--------------------------------------------------------------------------
        */

        $totalFoto = Dokumentasi::where(
            'uploaded_by',
            $user->id
        )
        ->where(
            'tipe_file',
            'foto'
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL VIDEO
        |--------------------------------------------------------------------------
        */

        $totalVideo = Dokumentasi::where(
            'uploaded_by',
            $user->id
        )
        ->where(
            'tipe_file',
            'video'
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | KEGIATAN TERBARU
        |--------------------------------------------------------------------------
        */

        $kegiatanTerbaru = Kegiatan::where(
            'created_by',
            $user->id
        )
        ->latest()
        ->take(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | FOLDER TERBARU
        |--------------------------------------------------------------------------
        */

        $folderTerbaru = FolderDokumentasi::with(
            'kegiatan'
        )
        ->whereHas(
            'kegiatan',
            function ($query) use ($user) {
                $query->where(
                    'created_by',
                    $user->id
                );
            }
        )
        ->latest()
        ->take(6)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | SEMUA FOLDER
        |--------------------------------------------------------------------------
        */

        $folders = FolderDokumentasi::with([
            'kegiatan',
            'dokumentasi'
        ])
        ->whereHas(
            'kegiatan',
            function ($query) use ($user) {
                $query->where(
                    'created_by',
                    $user->id
                );
            }
        )
        ->latest()
        ->get();


        /*
        |--------------------------------------------------------------------------
        | DOKUMENTASI TERBARU
        |--------------------------------------------------------------------------
        */

        $recentFiles = Dokumentasi::with([
            'folder.kegiatan'
        ])
        ->where(
            'uploaded_by',
            $user->id
        )
        ->latest()
        ->take(8)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | STORAGE
        |--------------------------------------------------------------------------
        */

        $totalStorage = Dokumentasi::where(
            'uploaded_by',
            $user->id
        )
        ->sum('ukuran_file');


        $storageMB = round(
            $totalStorage / 1024 / 1024,
            2
        );


        /*
        |--------------------------------------------------------------------------
        | UPLOAD HARI INI
        |--------------------------------------------------------------------------
        */

        $uploadHariIni = Dokumentasi::where(
            'uploaded_by',
            $user->id
        )
        ->whereDate(
            'created_at',
            today()
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'petugas.dashboardpetugas',
            compact(
                'user',
                'listPimpinan', // 2. Tambahkan $listPimpinan ke compact()

                'totalKegiatan',
                'totalFolder',
                'totalFoto',
                'totalVideo',

                'kegiatanTerbaru',

                'folderTerbaru',
                'folders',

                'recentFiles',

                'storageMB',

                'uploadHariIni'
            )
        );
    }
}