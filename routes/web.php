<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Middleware\EnsureUserIsActive;

/*
|--------------------------------------------------------------------------
| LOGIN & AUTH CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DataPetugasController;
use App\Http\Controllers\Admin\KegiatanController as AdminKegiatanController;
use App\Http\Controllers\Admin\FolderDokumentasiController as AdminFolderDokumentasiController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| PETUGAS CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\KegiatanController as PetugasKegiatanController;
use App\Http\Controllers\Petugas\FolderDokumentasiController as PetugasFolderDokumentasiController;
use App\Http\Controllers\Petugas\DokumentasiController;

/*
|--------------------------------------------------------------------------
| PIMPINAN CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboardController;
use App\Http\Controllers\Pimpinan\SeleksiController;
use App\Http\Controllers\Pimpinan\KurasiController;

/*
|--------------------------------------------------------------------------
| EDITOR CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Editor\DashboardController as EditorDashboardController;
use App\Http\Controllers\Editor\EditingController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| KURASI WA PIMPINAN (PUBLIC ACCESS VIA TOKEN)
|--------------------------------------------------------------------------
*/
Route::get('/kurasi-wa/{token}', [KurasiController::class, 'show'])->name('pimpinan.kurasi.wa');
Route::post('/kurasi-wa/{token}/submit', [KurasiController::class, 'submit'])->name('pimpinan.kurasi.submit');

/*
|--------------------------------------------------------------------------
| LOGIN & LOGOUT
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED & ACTIVE USER ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', EnsureUserIsActive::class])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFIL USER & 2FA
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')
        ->middleware('role:admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // Route Aktivasi & Nonaktifkan User
            Route::patch('/users/{id}/aktifkan', [UserController::class, 'aktifkan'])->name('users.aktifkan');
            Route::patch('/users/{id}/nonaktifkan', [UserController::class, 'nonaktifkan'])->name('users.nonaktifkan');

            // Route Download ZIP
            Route::get('/folder/{id}/download-zip', [AdminFolderDokumentasiController::class, 'downloadZip'])->name('folder.downloadZip');

            Route::resource('datapetugas', DataPetugasController::class);
            Route::resource('kegiatan', AdminKegiatanController::class);
            Route::resource('folder', AdminFolderDokumentasiController::class);
            Route::resource('users', UserController::class);

            Route::get('/hakakses', [DataPetugasController::class, 'hakAkses'])->name('hakakses');
            Route::put('/hakakses/{id}', [DataPetugasController::class, 'updateRole'])->name('hakakses.update');

            Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
        });

    /*
    |--------------------------------------------------------------------------
    | PETUGAS
    |--------------------------------------------------------------------------
    */
   
Route::prefix('petugas')
    ->middleware(['auth', 'role:petugas'])
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
        Route::resource('kegiatan', PetugasKegiatanController::class);

        Route::get('/folder', [PetugasFolderDokumentasiController::class, 'index'])->name('folder.index');
        Route::get('/folder/{folder}', [PetugasFolderDokumentasiController::class, 'show'])->name('folder.show');
        Route::post('/folder/{folder}/upload', [DokumentasiController::class, 'store'])->name('folder.upload');
        Route::post('/folder/{folder}/kirim-pimpinan', [PetugasFolderDokumentasiController::class, 'kirimPimpinan'])->name('folder.kirimPimpinan');
        Route::put('/folder/{folder}', [PetugasFolderDokumentasiController::class, 'update'])->name('folder.update');
        Route::delete('/folder/{folder}', [PetugasFolderDokumentasiController::class, 'destroy'])->name('folder.destroy');

        Route::get('/file/{dokumentasi}/preview', [PetugasFolderDokumentasiController::class, 'preview'])->name('folder.preview');
        Route::get('/file/{dokumentasi}/download', [PetugasFolderDokumentasiController::class, 'download'])->name('folder.download');
        Route::put('/file/{dokumentasi}/rename', [PetugasFolderDokumentasiController::class, 'renameFile'])->name('folder.renameFile');
        Route::delete('/file/{dokumentasi}', [PetugasFolderDokumentasiController::class, 'destroyFile'])->name('folder.destroyFile');

        // Dokumentasi Actions
        Route::delete('/dokumentasi/{id}', [DokumentasiController::class, 'destroy'])->name('dokumentasi.destroy');
        Route::put('/dokumentasi/{id}', [DokumentasiController::class, 'update'])->name('dokumentasi.update');
        Route::post('/dokumentasi/{id}/share', [DokumentasiController::class, 'share'])->name('dokumentasi.share');
        
        // Route untuk bagikan 1 file foto/video susulan ke Pimpinan
        Route::post('/dokumentasi/{id}/share-pimpinan', [DokumentasiController::class, 'shareSingleFileToPimpinan'])->name('dokumentasi.share-pimpinan');
    });

    /*
    |--------------------------------------------------------------------------
    | PIMPINAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('pimpinan')
        ->middleware('role:pimpinan')
        ->name('pimpinan.')
        ->group(function () {

            // Dashboard & Monitoring
            Route::get('/dashboard', [PimpinanDashboardController::class, 'index'])->name('dashboard');
            Route::get('/kegiatan', [PimpinanDashboardController::class, 'kegiatan'])->name('kegiatan');
            Route::get('/dokumentasi', [PimpinanDashboardController::class, 'dokumentasi'])->name('dokumentasi');

            // Hapus Folder (Cukup 1 baris ini)
            Route::delete('/folder/{id}', [PimpinanDashboardController::class, 'destroyFolder'])->name('folder.destroy');

            // Detail Dokumentasi
            Route::get('/dokumentasi/{id}', [SeleksiController::class, 'show'])->name('dokumentasi.show');

            // Kurasi / Seleksi Foto/Video
            Route::get('/kurasi', [SeleksiController::class, 'index'])->name('kurasi.index');
            Route::delete('/kurasi/{token}/file/{id}', [KurasiController::class, 'destroyFile'])->name('kurasi.destroyFile');
            Route::get('/seleksi', [SeleksiController::class, 'index'])->name('seleksi.index');
            Route::get('/seleksi/{id}', [SeleksiController::class, 'show'])->name('seleksi.show');
            Route::post('/seleksi/pilih/{id}', [SeleksiController::class, 'pilih'])->name('seleksi.pilih');
            Route::post('/seleksi/tolak/{id}', [SeleksiController::class, 'tolak'])->name('seleksi.tolak');
            Route::post('/seleksi/kirim-editor/{id}', [SeleksiController::class, 'kirimEditor'])->name('seleksi.kirimEditor');

            // Laporan/Statistik
            Route::get('/laporan', [PimpinanDashboardController::class, 'laporan'])->name('laporan');
            

    });
        });

    /*
    |--------------------------------------------------------------------------
    | EDITOR
    |--------------------------------------------------------------------------
    */
    Route::prefix('editor')
        ->middleware('role:editor')
        ->name('editor.')
        ->group(function () {

            Route::get('/dashboard', [EditorDashboardController::class, 'index'])->name('dashboard');
            
            // Tugas / Proses Editing
            Route::get('/tugas', [EditingController::class, 'index'])->name('tugas.index');
            Route::get('/proses-editing', [EditingController::class, 'index'])->name('prosesEditing');
            
            Route::get('/download-zip/{folderId}', [EditorDashboardController::class, 'downloadZip'])->name('downloadZip');
            Route::post('/upload-final/{dokumentasiId}', [EditingController::class, 'upload'])->name('uploadFinal');

            Route::get('/editing/{id}/download', [EditingController::class, 'download'])->name('editing.download');

            Route::resource('editing', EditingController::class);
            Route::put('/editing/{id}/selesai', [EditingController::class, 'selesai'])->name('editing.selesai');
        });


/*
|--------------------------------------------------------------------------
| TEST SESSION
|--------------------------------------------------------------------------
*/
Route::get('/test-session', function (Request $request) {
    $request->session()->put('test', 'berhasil');

    return [
        'session_id' => $request->session()->getId(),
        'session_test' => $request->session()->get('test'),
    ];
});