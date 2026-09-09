<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\FolderDokumentasi;
use App\Models\Dokumentasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

class KegiatanController extends Controller
{
    /**
     * Daftar kegiatan milik petugas yang sedang login.
     */
    public function index()
    {
        $kegiatan = Kegiatan::where('created_by', Auth::id())
            ->with(['folder' => function ($query) {
                $query->withCount('dokumentasi as files_count');
            }])
            ->latest()
            ->get();

        return view('petugas.kegiatan.index', compact('kegiatan'));
    }

    /**
     * Form tambah kegiatan.
     */
    public function create()
    {
        $pimpinan = User::where('role', 'pimpinan')
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();

        return view('petugas.kegiatan.create', compact('pimpinan'));
    }

    /**
     * Simpan kegiatan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan'    => 'required|string|max:255',
            'lokasi'           => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'waktu_mulai'      => 'nullable',
            'pimpinan_id'      => 'required|exists:users,id',
            'deskripsi'        => 'nullable|string',
        ]);

        $kegiatan = DB::transaction(function () use ($request) {
            $kegiatan = Kegiatan::create([
                'nama_kegiatan'    => $request->nama_kegiatan,
                'lokasi'           => $request->lokasi,
                'tanggal_kegiatan' => $request->tanggal_kegiatan,
                'waktu_mulai'      => $request->waktu_mulai,
                'pimpinan_id'      => $request->pimpinan_id,
                'deskripsi'        => $request->deskripsi,
                'created_by'       => Auth::id(),
            ]);

            FolderDokumentasi::create([
                'kegiatan_id' => $kegiatan->id,
                'created_by'  => Auth::id(),
                'nama_folder' => $kegiatan->nama_kegiatan,
                'total_foto'  => 0,
                'total_video' => 0,
            ]);

            return $kegiatan;
        });

        // REKAM LOG AKTIVITAS: MEMBUAT KEGIATAN
        LogHelper::record(
            'upload',
            null,
            'Membuat kegiatan liputan baru: ' . $kegiatan->nama_kegiatan . ' di ' . $kegiatan->lokasi
        );

        return redirect()
            ->route('petugas.folder.show', $kegiatan->id)
            ->with('success', 'Kegiatan berhasil dibuat.');
    }

    /**
     * Detail kegiatan.
     */
    public function show($id)
    {
        $kegiatan = Kegiatan::where('created_by', Auth::id())
            ->findOrFail($id);

        $folder = FolderDokumentasi::where('kegiatan_id', $kegiatan->id)->first();

        if (!$folder) {
            $folder = FolderDokumentasi::create([
                'kegiatan_id' => $kegiatan->id,
                'created_by'  => Auth::id(),
                'nama_folder' => $kegiatan->nama_kegiatan,
                'total_foto'  => 0,
                'total_video' => 0,
            ]);
        }

        $folder->load('dokumentasi', 'kegiatan');

        return view('petugas.kegiatan.show', compact('kegiatan', 'folder'));
    }

    /**
     * Upload banyak foto/video langsung dari Detail Kegiatan.
     */
    public function uploadDokumentasi(Request $request, $id)
    {
        $kegiatan = Kegiatan::where('created_by', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,mkv,webm',
                'max:512000',
            ],
        ], [
            'files.required' => 'Silakan pilih foto atau video terlebih dahulu.',
            'files.array'    => 'Format file tidak valid.',
            'files.min'      => 'Minimal pilih satu file.',
            'files.*.file'   => 'File yang dipilih tidak valid.',
            'files.*.mimes'  => 'File harus berupa foto atau video.',
            'files.*.max'    => 'Ukuran file maksimal 500 MB.',
        ]);

        $folder = FolderDokumentasi::firstOrCreate(
            ['kegiatan_id' => $kegiatan->id],
            [
                'created_by'  => Auth::id(),
                'nama_folder' => $kegiatan->nama_kegiatan,
                'total_foto'  => 0,
                'total_video' => 0,
            ]
        );

        $jumlahFoto = 0;
        $jumlahVideo = 0;

        foreach ($request->file('files') as $file) {
            if (str_starts_with($file->getMimeType(), 'image/')) {
                $tipeFile = 'foto';
                $jumlahFoto++;
            } elseif (str_starts_with($file->getMimeType(), 'video/')) {
                $tipeFile = 'video';
                $jumlahVideo++;
            } else {
                continue;
            }

            $path = $file->store('dokumentasi/' . $kegiatan->id, 'public');

            $doc = Dokumentasi::create([
                'folder_id'      => $folder->id,
                'uploaded_by'    => Auth::id(),
                'tipe_file'      => $tipeFile,
                'nama_file'      => $file->getClientOriginalName(),
                'path_file'      => $path,
                'ukuran_file'    => $file->getSize(),
                'status_progres' => 'pending',
                'uploaded_at'    => now(),
            ]);

            // REKAM LOG AKTIVITAS: UPLOAD DOKUMENTASI
            LogHelper::record(
                'upload',
                $doc->id,
                'Mengunggah file ' . $file->getClientOriginalName() . ' pada kegiatan ' . $kegiatan->nama_kegiatan
            );
        }

        $folder->update([
            'total_foto' => Dokumentasi::where('folder_id', $folder->id)->where('tipe_file', 'foto')->count(),
            'total_video' => Dokumentasi::where('folder_id', $folder->id)->where('tipe_file', 'video')->count(),
        ]);

        return redirect()
            ->route('petugas.kegiatan.show', $kegiatan->id)
            ->with('success', $jumlahFoto . ' foto dan ' . $jumlahVideo . ' video berhasil diupload.');
    }

    /**
     * Form edit kegiatan.
     */
    public function edit($id)
    {
        $kegiatan = Kegiatan::where('created_by', Auth::id())
            ->findOrFail($id);

        return view('petugas.kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Update kegiatan & nama folder.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan'    => 'required|string|max:255',
            'lokasi'           => 'nullable|string|max:255',
            'tanggal_kegiatan' => 'nullable|date',
            'waktu_mulai'      => 'nullable',
            'pimpinan_id'      => 'nullable|exists:users,id',
            'deskripsi'        => 'nullable|string',
        ]);

        $kegiatan = Kegiatan::where('created_by', Auth::id())
            ->findOrFail($id);

        $namaLama = $kegiatan->nama_kegiatan;

        // Update kegiatan
        $kegiatan->update([
            'nama_kegiatan'    => $request->nama_kegiatan,
            'lokasi'           => $request->lokasi ?? $kegiatan->lokasi,
            'tanggal_kegiatan' => $request->tanggal_kegiatan ?? $kegiatan->tanggal_kegiatan,
            'waktu_mulai'      => $request->waktu_mulai ?? $kegiatan->waktu_mulai,
            'pimpinan_id'      => $request->pimpinan_id ?? $kegiatan->pimpinan_id,
            'deskripsi'        => $request->deskripsi ?? $kegiatan->deskripsi,
        ]);

        // SINKRONISASI: Update nama folder terkait jika ada
        $folder = FolderDokumentasi::where('kegiatan_id', $kegiatan->id)->first();
        if ($folder) {
            $folder->update([
                'nama_folder' => $request->nama_kegiatan,
            ]);
        }

        // REKAM LOG AKTIVITAS: UPDATE KEGIATAN
        LogHelper::record(
            'edit_upload',
            null,
            'Mengubah data kegiatan dari "' . $namaLama . '" menjadi "' . $request->nama_kegiatan . '"'
        );

        return redirect()->back()->with('success', 'Nama kegiatan berhasil diperbarui.');
    }

    /**
     * Hapus kegiatan.
     */
    public function destroy($id)
    {
        $kegiatan = Kegiatan::where('created_by', Auth::id())
            ->with('folder.dokumentasi')
            ->findOrFail($id);

        $namaKegiatan = $kegiatan->nama_kegiatan;

        if ($kegiatan->folder) {
            foreach ($kegiatan->folder->dokumentasi as $doc) {
                if ($doc->path_file && Storage::disk('public')->exists($doc->path_file)) {
                    Storage::disk('public')->delete($doc->path_file);
                }
            }
            
            $kegiatan->folder->dokumentasi()->delete();
            $kegiatan->folder->delete();
        }

        $kegiatan->delete();

        // REKAM LOG AKTIVITAS: HAPUS KEGIATAN
        LogHelper::record(
            'archive',
            null,
            'Menghapus kegiatan liputan "' . $namaKegiatan . '" beserta seluruh dokumentasinya'
        );

        return redirect()->back()->with('success', 'Kegiatan beserta folder dan file berhasil dihapus seluruhnya.');
    }
}