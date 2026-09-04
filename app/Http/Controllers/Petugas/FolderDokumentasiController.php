<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\FolderDokumentasi;
use App\Models\Dokumentasi;
use App\Models\User;
use App\Models\DisposisiPimpinan;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FolderDokumentasiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW FOLDER
    |--------------------------------------------------------------------------
    */

    public function show($folderId)
    {
        $folder = FolderDokumentasi::findOrFail($folderId);

        $dokumentasi = Dokumentasi::where(
            'folder_id',
            $folder->id
        )
        ->with('uploader') // <-- Diubah di sini (baris 32)
        ->orderByDesc('uploaded_at')
        ->orderByDesc('id')
        ->get();

        $folder->load('kegiatan');

        return view('petugas.folder.show', [
            'folder' => $folder,
            'dokumentasi' => $dokumentasi,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPLOAD MULTIPLE FILE
    |--------------------------------------------------------------------------
    */

    public function upload(Request $request, $folderId)
    {
        $folder = FolderDokumentasi::findOrFail($folderId);

        if (!Auth::check()) {
            abort(403);
        }

        $request->validate([
            'files' => [
                'required',
                'array',
                'min:1',
            ],

            'files.*' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,gif,mp4,mov,avi,mkv,webm',
                'max:512000',
            ],
        ], [
            'files.required' => 'Silakan pilih minimal satu file.',
            'files.array'    => 'Format file tidak valid.',
            'files.min'      => 'Silakan pilih minimal satu file.',
            'files.*.required' => 'File tidak boleh kosong.',
            'files.*.file'   => 'File yang dipilih tidak valid.',
            'files.*.mimes'  => 'File harus berupa foto atau video.',
            'files.*.max'    => 'Ukuran setiap file maksimal 500 MB.',
        ]);

        foreach ($request->file('files') as $file) {
            $extension = strtolower(
                $file->getClientOriginalExtension()
            );

            if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                $tipeFile = 'foto';
            } else {
                $tipeFile = 'video';
            }

            $namaAsli = $file->getClientOriginalName();

            $pathFile = $file->store(
                'dokumentasi/' . $folder->id,
                'public'
            );

            Dokumentasi::create([
                'folder_id'       => $folder->id,
                'uploaded_by'     => Auth::id(),
                'tipe_file'       => $tipeFile,
                'nama_file'       => $namaAsli,
                'path_file'       => $pathFile,
                'ukuran_file'     => $file->getSize(),
                'status_progres'  => 'pending',
                'catatan_progres' => null,
                'uploaded_at'     => now(),
            ]);
        }

        return redirect()
            ->route(
                'petugas.folder.show',
                ['folder' => $folder->id]
            )
            ->with('success', 'Dokumentasi berhasil diupload.');
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
            'nama_folder' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $folder->update([
            'nama_folder' => $request->nama_folder,
        ]);

        return redirect()
            ->route(
                'petugas.folder.show',
                ['folder' => $folder->id]
            )
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

        $dokumentasi = Dokumentasi::where(
            'folder_id',
            $folder->id
        )->get();

        foreach ($dokumentasi as $file) {
            if (
                $file->path_file &&
                Storage::disk('public')->exists($file->path_file)
            ) {
                Storage::disk('public')->delete($file->path_file);
            }
        }

        Dokumentasi::where('folder_id', $folder->id)->delete();

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
            'nama_file' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $namaBaru = trim($request->nama_file);

        $extension = pathinfo(
            $dokumentasi->nama_file,
            PATHINFO_EXTENSION
        );

        if (
            $extension &&
            !Str::endsWith(
                strtolower($namaBaru),
                '.' . strtolower($extension)
            )
        ) {
            $namaBaru .= '.' . $extension;
        }

        $dokumentasi->update([
            'nama_file' => $namaBaru,
        ]);

        return redirect()
            ->route(
                'petugas.folder.show',
                ['folder' => $dokumentasi->folder_id]
            )
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

        if (
            $dokumentasi->path_file &&
            Storage::disk('public')->exists($dokumentasi->path_file)
        ) {
            Storage::disk('public')->delete($dokumentasi->path_file);
        }

        $dokumentasi->delete();

        return redirect()
            ->route(
                'petugas.folder.show',
                ['folder' => $folderId]
            )
            ->with('success', 'File berhasil dihapus.');
    }


    /*
    |--------------------------------------------------------------------------
    | KIRIM NOTIFIKASI WA KE PIMPINAN
    |--------------------------------------------------------------------------
    */

    public function kirimPimpinan(Request $request, $folderId)
    {
        $folder = FolderDokumentasi::findOrFail($folderId);
        $pimpinanList = User::where('role', 'pimpinan')->get();

        foreach ($pimpinanList as $pimpinan) {
            $token = Str::random(40);

            DisposisiPimpinan::create([
                'folder_id'   => $folder->id,
                'pimpinan_id' => $pimpinan->id,
                'token'       => $token,
            ]);

            $magicUrl = route('pimpinan.kurasi.wa', $token);

            WhatsAppService::sendMagicLink(
                $pimpinan->no_hp,
                $pimpinan->name,
                $folder->nama_folder,
                $magicUrl
            );
        }

        return back()->with('success', 'Notifikasi WhatsApp berhasil dikirim ke Pimpinan!');
    }
}