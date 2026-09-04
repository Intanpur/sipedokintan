<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;

class DokumentasiController extends Controller
{
    public function index()
    {
        $files = Dokumentasi::with([
                    'uploader',
                    'folder',
                    'editor',
                    'approver'
                ])
                ->latest()
                ->get();

        return view('admin.dokumentasi.index', compact('files'));
    }

    public function show($id)
    {
        $file = Dokumentasi::with([
                    'uploader',
                    'folder',
                    'activityLogs'
                ])
                ->findOrFail($id);

        return view('admin.dokumentasi.show', compact('file'));
    }

    public function destroy($id)
    {
        $file = Dokumentasi::findOrFail($id);

        if(file_exists(storage_path('app/public/'.$file->path_file))){
            unlink(storage_path('app/public/'.$file->path_file));
        }

        $file->delete();

        return back()->with('success','Dokumentasi berhasil dihapus');
    }
}