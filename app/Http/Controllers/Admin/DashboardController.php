<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kegiatan;
use App\Models\FolderDokumentasi;
use App\Models\Dokumentasi;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $tahunIni = date('Y');
        $today = Carbon::today('Asia/Jakarta');

        // 1. Data Ringkasan Metric
        $totalPetugas       = User::where('role', 'petugas')->count();
        $totalUsers         = User::count();
        $totalKegiatan      = Kegiatan::count();
        $totalFolder        = FolderDokumentasi::count();
        $totalFoto          = Dokumentasi::where('tipe_file', 'foto')->count();
        $totalVideo         = Dokumentasi::where('tipe_file', 'video')->count();
        $dokumentasiUnggah  = Dokumentasi::count();
        $dokumentasiSelesai = Dokumentasi::where('status', 'selesai')->count();

        $progres = $dokumentasiUnggah > 0
            ? round(($dokumentasiSelesai / $dokumentasiUnggah) * 100)
            : 0;

        // 2. Data Grafik Bulanan (Jan - Des)
        $dataUploadBulanan = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $dataUploadBulanan[] = Dokumentasi::whereYear('created_at', $tahunIni)
                ->whereMonth('created_at', $bulan)
                ->count();
        }

       
// 3. TABEL MONITORING KEGIATAN TERBARU
$kegiatanTerbaru = Kegiatan::with(['folder.user', 'createdBy'])
    ->withCount('folder')
    ->latest()
    ->take(5)
    ->get();

       // 4. WIDGET FOLDER TERBARU (Hitung jumlah foto dan video per folder)
$folderTerbaru = FolderDokumentasi::withCount([
    'dokumentasi as foto_count' => function ($query) {
        $query->where('tipe_file', 'foto');
    },
    'dokumentasi as video_count' => function ($query) {
        $query->where('tipe_file', 'video');
    }
])
->latest()
->take(5)
->get();

        // 5. WIDGET AKTIVITAS HARI INI
        $folderHariIni          = FolderDokumentasi::whereDate('created_at', $today)->count();
        $fotoHariIni            = Dokumentasi::where('tipe_file', 'foto')->whereDate('created_at', $today)->count();
        $videoHariIni           = Dokumentasi::where('tipe_file', 'video')->whereDate('created_at', $today)->count();
        $kegiatanSelesaiHariIni = Kegiatan::whereDate('created_at', $today)->count();

        // 6. TABEL STATUS & AKTIVITAS TIM AKTIF
        // Ambil log aktivitas terbaru beserta relasi user
        // 6. TABEL STATUS & AKTIVITAS TIM AKTIF
$recentActivities = ActivityLog::with('user')
    ->latest()
    ->take(10)
    ->get();

// Fallback jika ActivityLog kosong: Ambil user yang diurutkan berdasarkan aktivitas paling akhir (updated_at)
$userStatusList = User::orderBy('updated_at', 'desc')->get()->map(function ($user) {
    // Pastikan Carbon membaca waktu berdasarkan timezone Asia/Jakarta
    $lastActive = $user->updated_at ? Carbon::parse($user->updated_at)->timezone('Asia/Jakarta') : null;
    
    // User dianggap ONLINE jika beraktivitas dalam 10 menit terakhir
    $user->is_online = $lastActive ? $lastActive->gt(Carbon::now('Asia/Jakarta')->subMinutes(10)) : false;
    $user->last_active_time = $lastActive;
    
    return $user;
});
        // 7. Data User untuk Modal / Peran User
        $users = User::latest()->get();

        return view('admin.dashboard', compact(
            'totalPetugas',
            'totalUsers',
            'totalKegiatan',
            'totalFolder',
            'totalFoto',
            'totalVideo',
            'dokumentasiUnggah',
            'dokumentasiSelesai',
            'progres',
            'dataUploadBulanan',
            'kegiatanTerbaru',
            'folderTerbaru',
            'folderHariIni',
            'fotoHariIni',
            'videoHariIni',
            'kegiatanSelesaiHariIni',
            'users',
            'recentActivities',
            'userStatusList'
        ));
    }

    public function updateUserRoleAndStatus(Request $request, User $user)
    {
        $request->validate([
            'role'      => 'required|in:admin,petugas,pimpinan,editor',
            'is_active' => 'required|boolean',
        ]);

        $user->update([
            'role'      => $request->role,
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('success', "Role dan status akun {$user->name} berhasil diperbarui.");
    }
}