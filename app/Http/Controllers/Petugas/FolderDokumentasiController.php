<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\FolderDokumentasi;
use App\Models\Dokumentasi;
use App\Models\User;
use App\Models\DisposisiPimpinan;
use App\Services\FonnteService;
use App\Helpers\LogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FolderDokumentasiController extends Controller
{
    protected FonnteService $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX FOLDER (UNTUK PETUGAS)
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = FolderDokumentasi::with(['kegiatan', 'dokumentasi'])->latest();

        if ($request->filled('search')) {
            $query->where('nama_folder', 'like', '%' . $request->search . '%');
        }

        $folders = $query->paginate(12);

        return view('petugas.folder.index', compact('folders'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW FOLDER
    |--------------------------------------------------------------------------
    */
    public function show($folderId)
    {
        $folder = FolderDokumentasi::findOrFail($folderId);

        $dokumentasi = Dokumentasi::where('folder_id', $folder->id)
            ->with('uploader')
            ->orderByDesc('uploaded_at')
            ->orderByDesc('id')
            ->get();

        $folder->load('kegiatan');

        $pimpinanList = User::where('role', 'pimpinan')->get();

        return view('petugas.folder.show', [
            'folder'       => $folder,
            'dokumentasi'  => $dokumentasi,
            'pimpinanList' => $pimpinanList,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPLOAD MULTIPLE FILE
    |--------------------------------------------------------------------------
    */
    public function upload(Request $request, $folderId)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:50000',
        ]);

        $folder = FolderDokumentasi::findOrFail($folderId);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('dokumentasi', 'public');
                $tipe = str_contains($file->getMimeType(), 'video') ? 'video' : 'foto';

                $dokumentasi = Dokumentasi::create([
                    'folder_id'   => $folder->id,
                    'nama_file'   => $file->getClientOriginalName(),
                    'path_file'   => $path,
                    'tipe_file'   => $tipe,
                    'ukuran_file' => $file->getSize(),
                    'uploaded_at' => now(),
                    'uploaded_by' => Auth::id(),
                ]);

                LogHelper::record(
                    'upload', 
                    $dokumentasi->id, 
                    'Mengunggah file ' . $file->getClientOriginalName() . ' ke folder ' . $folder->nama_folder
                );
            }
        }

        return redirect()->back()->with('success', 'Dokumentasi berhasil diunggah.');
    }

    /*
    |--------------------------------------------------------------------------
    | RENAME FOLDER
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $folderId)
    {
        $folder = FolderDokumentasi::findOrFail($folderId);

        $request->validate([
            'nama_folder' => 'required|string|max:255',
        ]);

        $namaLama = $folder->nama_folder;
        $folder->update([
            'nama_folder' => $request->nama_folder,
        ]);

        LogHelper::record(
            'edit_upload',
            null,
            'Mengubah nama folder dari "' . $namaLama . '" menjadi "' . $request->nama_folder . '"'
        );

        return redirect()
            ->route('petugas.folder.show', ['folder' => $folder->id])
            ->with('success', 'Nama folder berhasil diubah.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE FOLDER
    |--------------------------------------------------------------------------
    */
    public function destroy($folderId)
    {
        $folder = FolderDokumentasi::findOrFail($folderId);
        $dokumentasi = Dokumentasi::where('folder_id', $folder->id)->get();

        foreach ($dokumentasi as $file) {
            if ($file->path_file && Storage::disk('public')->exists($file->path_file)) {
                Storage::disk('public')->delete($file->path_file);
            }
        }

        LogHelper::record(
            'archive',
            null,
            'Menghapus folder ' . $folder->nama_folder . ' beserta seluruh isinya'
        );

        Dokumentasi::where('folder_id', $folder->id)->delete();
        $folder->disposisi()->delete();
        $folder->delete();

        return redirect()
            ->route('petugas.dashboard')
            ->with('success', 'Folder berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | PREVIEW FILE
    |--------------------------------------------------------------------------
    */
    public function preview($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        $disk = Storage::disk('public');

        if (!$dokumentasi->path_file || !$disk->exists($dokumentasi->path_file)) {
            abort(404, 'File tidak ditemukan.');
        }

        $path = $disk->path($dokumentasi->path_file);

        if (!file_exists($path)) {
            abort(404, 'File fisik tidak ditemukan.');
        }

        LogHelper::record('view', $dokumentasi->id, 'Melihat/Membuka preview file ' . $dokumentasi->nama_file);

        return response()->file($path);
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD FILE
    |--------------------------------------------------------------------------
    */
    public function download($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        $disk = Storage::disk('public');

        if (!$dokumentasi->path_file || !$disk->exists($dokumentasi->path_file)) {
            abort(404, 'File tidak ditemukan.');
        }

        LogHelper::record('download', $dokumentasi->id, 'Mengunduh file ' . $dokumentasi->nama_file);

        return response()->download(
            $disk->path($dokumentasi->path_file),
            $dokumentasi->nama_file
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RENAME FILE
    |--------------------------------------------------------------------------
    */
    public function renameFile(Request $request, $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        $request->validate([
            'nama_file' => 'required|string|max:255',
        ]);

        $namaLama = $dokumentasi->nama_file;
        $namaBaru = trim($request->nama_file);
        $extension = pathinfo($dokumentasi->nama_file, PATHINFO_EXTENSION);

        if ($extension && !Str::endsWith(strtolower($namaBaru), '.' . strtolower($extension))) {
            $namaBaru .= '.' . $extension;
        }

        $dokumentasi->update([
            'nama_file' => $namaBaru,
        ]);

        LogHelper::record(
            'edit_upload',
            $dokumentasi->id,
            'Mengubah nama file dari "' . $namaLama . '" menjadi "' . $namaBaru . '"'
        );

        return redirect()
            ->route('petugas.folder.show', ['folder' => $dokumentasi->folder_id])
            ->with('success', 'Nama file berhasil diubah.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE FILE
    |--------------------------------------------------------------------------
    */
    public function destroyFile($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        $folderId = $dokumentasi->folder_id;
        $namaFile = $dokumentasi->nama_file;

        if ($dokumentasi->path_file && Storage::disk('public')->exists($dokumentasi->path_file)) {
            Storage::disk('public')->delete($dokumentasi->path_file);
        }

        LogHelper::record(
            'archive',
            $dokumentasi->id,
            'Menghapus file ' . $namaFile
        );

        $dokumentasi->delete();

        return redirect()
            ->route('petugas.folder.show', ['folder' => $folderId])
            ->with('success', 'File berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | KIRIM FOLDER KE PIMPINAN (KURASI & WA)
    |--------------------------------------------------------------------------
    */
    public function kirimPimpinan(Request $request, $folderId)
    {
        $request->validate([
            'pimpinan_id' => 'required|exists:users,id',
        ]);

        $folder = FolderDokumentasi::with('dokumentasi')->findOrFail($folderId);
        $pimpinan = User::findOrFail($request->pimpinan_id);

        $token = Str::random(40);

        // 1. BUAT / UPDATE DISPOSISI AGAR PASTI MASUK KE MENU KURASI PIMPINAN
        DisposisiPimpinan::updateOrCreate(
            [
                'folder_id'   => $folder->id,
                'pimpinan_id' => $pimpinan->id,
            ],
            [
                'token'         => $token,
                'status_review' => 'pending',
            ]
        );

        // 2. KIRIM WA JIKA NOMOR HP TERSEDIA
        if (!empty($pimpinan->no_hp)) {
            $magicUrl = route('pimpinan.kurasi.wa', $token);
            
            // Mencoba kirim WA via Fonnte tanpa membatalkan proses disposisi jika gagal
            try {
                $this->fonnteService->sendMagicLink(
                    $pimpinan->no_hp,
                    $pimpinan->name,
                    $folder,
                    $magicUrl
                );
            } catch (\Exception $e) {
                // Abaikan error WA agar data di web tetap masuk
            }
        }

        // LOG AKTIVITAS
        LogHelper::record(
            'selected',
            null,
            'Berhasil mengirimkan folder "' . $folder->nama_folder . '" ke menu Kurasi Pimpinan (' . $pimpinan->name . ')'
        );

        return back()->with('success', 'Folder berhasil dikirim ke menu Kurasi Pimpinan ' . $pimpinan->name . '!');
    }
}